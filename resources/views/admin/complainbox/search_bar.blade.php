<form class="form-inline" ic-target="#result" ic-get-from="{{ route('admin.complainbox.search') }}"  id="frm">
    @csrf
    <div class="form-group">
        {{ Form::select('complain_type_id', array(""=>'Type')+$complainTypes->toArray() , null, array('class' => 'form-control input-sm') ) }}
    </div>
    <div class="form-group">
        <input type="text"  name="name" class="form-control input-sm" value="" placeholder="Name" >
    </div>
    {{-- <br> --}}
    <div class="form-group">
        <input type="text" name="hsc_roll" size="10" class="form-control input-sm" value="" placeholder="HSC Roll" >
    </div>
    <div class="form-group">
        {{ Form::select('hsc_board', array(""=>'HSC Board')+$hsc_board , null, array('class' => 'form-control input-sm') ) }}
    </div>

    <div class="form-group">
        {{ Form::select('hsc_year', array(""=>'HSC Year')+$hsc_year , null, array('class' => 'form-control input-sm') ) }}
    </div>

    <div class="form-group">
        <div class="input-group">
            <input type="text" name="complain_date" class="form-control input-sm datepicker" value="" placeholder="Complain Date" >
            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::select('status', array(""=>'Status')+$status , null, array('class' => 'form-control input-sm') ) }}
    </div>

    <div class="form-group">
        {{ Form::select('orderBy', $orderBy , null, array('class' => 'form-control input-sm') ) }}
    </div>

    <div class="form-group">
        <button type="submit" name="search"  class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button>
    </div>
</form>
