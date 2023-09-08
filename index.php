<div class="video-wrapper">
    <video id="cam1" autoplay playsinline></video>
</div>


<button id="capture" class="btn btn-primary">Take a picture</button>


<script>
    const camera = document.querySelector("#cam1");
    const capture = document.querySelector("#capture");

    let camera_stream = null;
    let media_recorder = null;
    let blobs_recorded = [];

    window.onload = async function() {
        camera_stream = await navigator.mediaDevices.getUserMedia({
            video: {
                width: {
                    min: 640,
                    ideal: 640,
                    max: 640
                },
                height: {
                    min: 480,
                    ideal: 480,
                    max: 480
                },
                facingMode: "environment",
            },
            audio: false,
        });
        camera.srcObject = camera_stream;
        // set MIME type of recording as video/webm
        media_recorder = new MediaRecorder(camera_stream, {
            mimeType: "video/webm",
        });

        // event : new recorded video blob available
        media_recorder.addEventListener("dataavailable", function(e) {
            blobs_recorded.push(e.data);
        });


        // start recording with each recorded blob having 1 second video
        media_recorder.start(1000);
    };

    function getVideoResult() {
        return new Promise((res) => {
            let blobs = new Blob(blobs_recorded, {
                type: "video/webm"
            });
            let video_local = URL.createObjectURL(blobs);
            res(blobs);
        })
    }

    function takeSnap() {
        return new Promise((res) => {
            const canvas = document.createElement("canvas"); // create a canvas
            const ctx = canvas.getContext("2d"); // get its context
            canvas.width = camera.videoWidth; // set its size to the one of the video
            canvas.height = camera.videoHeight;
            ctx.drawImage(camera, 0, 0); // the video
            canvas.toBlob((blob) => {
                const image_url = URL.createObjectURL(blob);
                res(blob);
            }, "image/jpeg"); // request a Blob from the canvas
        });
    }

    capture.addEventListener("click", async function() {
        media_recorder.stop();
        const imageBlob = await takeSnap();
        const videoBlob = await getVideoResult();
        console.log(imageBlob);
        
        var formData = new FormData();
        formData.append('image', imageBlob, 'AnImage.jpeg');
        formData.append('video', videoBlob, 'AnVideo.webm');
        formData.append('test', "hello world");
        

        var xhr = new XMLHttpRequest();
        xhr.open('post', 'upload.php', true);
        xhr.onload = function(e) {
            console.log("File uploading completed!");
            window.location.reload();
        };
    
        // do the uploading
        console.log("File uploading started!");
        xhr.send(formData);


    });
</script>