// initialize the video element on the page
const video = document.getElementById('video');
const containerDiv = document.getElementById('d');
let videoAspectRatio = null;
let processFrame = null;
let animationFrameId = null;

video.width = containerDiv.offsetWidth;
video.height = 400;
video.style.top = 0;
video.style.top = 0;
video.style.left = 0;
//hide the video element until the video is ready
video.style.visibility = 'hidden';

let loadingScreen = document.getElementById('loading');
let canvas = null

const modelPath = '/assets/plugins/face-api/models';

Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri(modelPath),
    faceapi.nets.faceLandmark68Net.loadFromUri(modelPath),
    // faceapi.nets.faceExpressionNet.loadFromUri(modelPath),
]).then(() => {
    startVideo();
})
    .catch(error => {
        console.error('Error loading face detection models:', error);
        // Handle the error, e.g., display an error message to the user
        alert(error);
    });



function startVideo() {

    canvas = document.getElementById('box');
    if (canvas) {
        canvas.remove();
    }

    navigator.mediaDevices.getUserMedia({ video: true },)
        .then(function (stream) {
            videoAspectRatio = stream.getVideoTracks()[0].getSettings().aspectRatio;
            video.srcObject = stream;

            // open faceapi when play triggered
            video.onplay = function () {
                animationFrameId = window.requestAnimationFrame(processFrame);
            };

            // cancel faceapi when paused or ended
            video.onpause = video.onended = function () {
                window.cancelAnimationFrame(animationFrameId);
                if (canvas) {
                    const context = canvas.getContext('2d');
                    canvas.remove();
                }
            };
        })
        .catch(err => {
            document.getElementById('no-camera').style.display = 'block';
        });
}


video.addEventListener('play', () => {

    //video is ready, show the video element and hide the loading screen
    video.style.visibility = 'visible';
    loadingScreen.style.display = 'none';

    // update the canvas dimensions to match the video dimensions
    let containerDiv = document.getElementById('d');
    video.width = containerDiv.offsetWidth;
    video.height = videoAspectRatio ? containerDiv.offsetWidth / videoAspectRatio : 400;

    //create a canvas element that will be used to display the detected image
    const canvas = faceapi.createCanvasFromMedia(video);
    canvas.id = 'box';
    canvas.style.top = '0px';
    canvas.style.left = '0px';
    canvas.style.padding = '0px';
    canvas.style.margin = '0px';
    canvas.style.position = 'absolute';
    canvas.width = containerDiv.width;
    canvas.height = containerDiv.height;

    //append the canvas element to the page
    containerDiv.append(canvas);

    const displaySize = { width: video.width, height: video.height };
    faceapi.matchDimensions(canvas, displaySize);

    let wasMouthOpen = false;
    let capturedImageData = null;

    const paddingX = 15;
    const paddingY = 50;
    let intervalId = null;

    processFrame = async () => {
        const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks();

        if (detection) {
            let resizedDetection = faceapi.resizeResults(detection, displaySize);

            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);

            faceapi.draw.drawDetections(canvas, resizedDetection);
            // faceapi.draw.drawFaceLandmarks(canvas, resizedDetection);
            // faceapi.draw.drawFaceExpressions(canvas, resizedDetection);

            const isMouthClosed = !isMouthOpen(detection)

            if (wasMouthOpen && isMouthClosed) {

                let box = detection.detection.box;

                box = new faceapi.Rect(box.x - paddingX, box.y - paddingY, box.width + paddingX * 2, box.height + paddingY * 2)


                const tempCanvas = document.createElement('canvas');
                tempCanvas.width = box.width;
                tempCanvas.height = box.height;
                const tempCtx = tempCanvas.getContext('2d');
                tempCtx.drawImage(video, box.x, box.y, box.width, box.height, 0, 0, box.width, box.height);

                const previewCanvas = document.getElementById('face-preview');
                previewCanvas.width = box.width;
                previewCanvas.height = box.height;
                const ctx = previewCanvas.getContext('2d');
                ctx.drawImage(tempCanvas, 0, 0, box.width, box.height, 0, 0, previewCanvas.width, previewCanvas.height);

                capturedImageData = previewCanvas.toDataURL('image/jpeg');

                //document.getElementById('your-button-id') && document.getElementById('your-button-id').remove();

                const button = document.getElementById('save-button');
                button.removeEventListener('click', buttonClicked);
                // button.innerHTML = '<i class="fa fa-save"></i> Save';
                // button.id = 'your-button-id';
                // button.className = 'btn btn-primary';
                // $('#modal-footer').append(button);

                button.addEventListener('click', buttonClicked);

                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
                $('#my-modal').modal('show');
                video.pause();
                //clearInterval(intervalId)

                //clear canvas
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
                //canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            }

            wasMouthOpen = isMouthOpen(detection)

            window.cancelAnimationFrame(animationFrameId);
        }

        animationFrameId = window.requestAnimationFrame(processFrame);

    }

    animationFrameId = window.requestAnimationFrame(processFrame);

    function buttonClicked() {
        if (capturedImageData) {
            this.disabled = true;
            // Send image data to the server using POST ajax request
            const xhr = new XMLHttpRequest();
            xhr.open("POST", '/selfie-capture', false);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            xhr.send("image=" + encodeURIComponent(capturedImageData));
            // Clear capturedImageData
            capturedImageData = null;
            //redirect to a new page
            window.location.href = '/remote-capture-complete';

        }
    }

    function isMouthOpen(face) {
        const landmarks = face.landmarks;
        const mouth = landmarks.getMouth();
        const mouthTop = mouth[14].y;
        const mouthBottom = mouth[18].y;
        const mouthHeight = mouthBottom - mouthTop;
        return mouthHeight > 6;
    }

});

