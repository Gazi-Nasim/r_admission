<?php

namespace App\Library;


use App\Models\Hsc;
use Arr;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class EducationBoardCrawler
{
    private $url;

    public function __construct()
    {
        $this->url = 'http://www.educationboardresults.gov.bd/';
    }


    /**
     * @param Hsc $student
     *
     * @return array
     */
    public function getBoardDate(Hsc $student): array
    {

        $board_mapping = [
            strtoupper('barishal')   => 'barisal',
            strtoupper('chittagong') => 'chittagong',
            strtoupper('comilla')    => 'comilla',
            strtoupper('dhaka')      => 'dhaka',
            strtoupper('dinajpur')   => 'dinajpur',
            strtoupper('jashore')    => 'jessore',
            strtoupper('mymensingh') => 'mymensingh',
            strtoupper('rajshahi')   => 'rajshahi',
            strtoupper('sylhet')     => 'sylhet',
            strtoupper('madrasah')   => 'madrasah',
            strtoupper('BTEB')       => 'tec',
            strtoupper('TEC')        => 'tec',
            strtoupper('DIBS')       => 'dibs',
            strtoupper('BM/DCOM')    => 'tec',
        ];


        $exam  = 'hsc';
        $year  = $student->HSC_PASS_YEAR;
        $board = $board_mapping[$student->HSC_BOARD_NAME];
        $roll  = $student->HSC_ROLL_NO;
        $reg   = $student->HSC_REGNO;

        $browser = new HttpBrowser(HttpClient::create());

        $crawler = $browser->request('GET', $this->url);


        $form = $crawler->selectButton('Submit')->form();

        $form['sr']      = '3';
        $form['et']      = '0';
        $form['button2'] = 'Submit';
        $form['roll']    = $roll;
        $form['reg']     = $reg;
        $form['exam']    = $exam;
        $form['year']    = $year;
        $form['board']   = $board;
        $form['value_s'] = $this->evaluate_math($crawler);

        $c = $browser->submit($form);

        $data['info']   = $this->getStudentInfo($c);
        $data['result'] = $this->getStudentGrades($c);


        return $data;
    }


    /**
     * @param Crawler|null $crawler
     *
     * @return mixed
     */
    private function evaluate_math(?Crawler $crawler)
    {
        $table = $crawler->filter('table.black12bold')->first();
        $td    = $table->filter('tr')->eq(6)->filter('td')->eq(1);

        $exp = trim($td->text());

        return eval("return $exp;");
    }


    /**
     * @param Crawler|null $c
     *
     * @return array
     */
    private function getStudentInfo(?Crawler $c): array
    {
        $table_info = $c->filter('table.black12')->first();

        $td_data = [];
        $table_info->filter('td')->each(function (Crawler $td) use (&$td_data) {
            $td_data[] = $td->html();
        });


        $d = array_chunk($td_data, 2);

        return Arr::pluck($d, '1', '0');
    }


    /**
     * @param Crawler|null $c
     *
     * @return array
     */
    private function getStudentGrades(?Crawler $c): array
    {
        $table_grades = $c->filter('table.black12')->last();

        $grades = [];
        $table_grades->filter('tr')->each(function (Crawler $tr) use (&$grades) {

            $data = [
                'Code'    => $tr->filter('td')->eq(0)->text(),
                'Subject' => $tr->filter('td')->eq(1)->text(),
                'Grade'   => $tr->filter('td')->eq(2)->text(),
            ];

            $grades[] = $data;

        });

        return $grades;
    }
}
