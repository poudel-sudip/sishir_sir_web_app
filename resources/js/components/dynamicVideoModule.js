$(document).ready(function(){

    $('.view-video').on('click',function (){

        var videourl=$(this).attr('video-url');
        var videotitle=$(this).attr('video-title');
        var videoModal = $('#videoModal').modal();


        var detectorResponse=detector(videourl);
        var finalPlayer=getVideoPlayer(detectorResponse);
        var videoPlayer=$('#videoPlayer');
        videoPlayer.html('');

        videoModal.on('shown.bs.modal',function (){
            videoPlayer.html('');
            // $('#playingVideo').attr('src',videourl);
            $('#playingTitle').html(videotitle);
            videoPlayer.append(finalPlayer);
        });

        videoModal.on('show.bs.modal',function (){
            videoPlayer.html('');
            // $('#playingVideo').attr('src',videourl);
            $('#playingTitle').html(videotitle);
            videoPlayer.append(finalPlayer);
        });

        videoModal.on('hide.bs.modal',function (){
            videoPlayer.html('');
            // $('#playingVideo').attr('src',videourl);
            $('#playingTitle').html('Null');
            videoPlayer.html('');

        });

    });



    //function to detect the id and platform (youtube, vimeo, dailymotion or uploaded) of the videos
    function detector(videoUrl){
        // var getVideoUrl     = videoUrl.parts.videoUrl;
        var url           = videoUrl;
        var id            = '';
        var player   = '';
        var url_check = '';

        if(url.indexOf('youtu.be') >= 0){
            player = 'youtube';
            id     = url.substring(url.lastIndexOf("/")+1, url.length);
        }

        if(url.indexOf("youtube") >= 0){
            player = 'youtube'
            if(url.indexOf("</iframe>") >= 0){
                var fin = url.substring(url.indexOf("embed/")+6, url.length)
                id      = fin.substring(fin.indexOf('"'), 0);
            }else{
                if(url.indexOf("&") >= 0)
                    id = url.substring(url.indexOf("?v=")+3, url.indexOf("&"));
                else
                    id = url.substring(url.indexOf("?v=")+3, url.length);
            }
            url_check = "https://gdata.youtube.com/feeds/api/videos/" + id + "?v=2&alt=json";
            //"https://gdata.youtube.com/feeds/api/videos/" + id + "?v=2&alt=json"
        }

        if(url.indexOf("vimeo") >= 0){
            player = 'vimeo'
            if(url.indexOf("</iframe>") >= 0){
                var fin = url.substring(url.lastIndexOf('vimeo.com/"')+6, url.indexOf('>'))
                id      = fin.substring(fin.lastIndexOf('/')+1, fin.indexOf('"',fin.lastIndexOf('/')+1))
            }else{
                id = url.substring(url.lastIndexOf("/")+1, url.length)
            }
            url_check = 'http://vimeo.com/api/v2/video/' + id + '.json';
            //'http://vimeo.com/api/v2/video/' + video_id + '.json';
        }

        if(url.indexOf('dai.ly') >= 0){
            player = 'dailymotion';
            id     = url.substring(url.lastIndexOf("/")+1, url.length);
        }

        if(url.indexOf("dailymotion") >= 0){
            player = 'dailymotion';
            if(url.indexOf("</iframe>") >= 0){
                var fin = url.substring(url.indexOf('dailymotion.com/')+16, url.indexOf('></iframe>'))
                id      = fin.substring(fin.lastIndexOf('/')+1, fin.lastIndexOf('"'))
            }else{
                if(url.indexOf('_') >= 0)
                    id = url.substring(url.lastIndexOf('/')+1, url.indexOf('_'))
                else
                    id = url.substring(url.lastIndexOf('/')+1, url.length);
            }
            url_check = 'https://api.dailymotion.com/video/' + id;
            // https://api.dailymotion.com/video/x26ezrb
        }

        if(url.indexOf('vidyard') >= 0){
            player = 'vidyard';
            id = url.substring(url.lastIndexOf("/")+1, url.indexOf("?"));
        }

        if(url.indexOf('zoom') >= 0){
            player = 'zoom';
            id = url;
        }

        if(player==='' && id==='')
        {
            player='uploaded';
            id=url;
        }

        return {'player':player,'video_id':id};
    }

    //detect the video and set the player
    function getVideoPlayer(response){
        var url = "";
        var player="";
        if(response.player == "youtube"){
            url = "https://www.youtube.com/embed/"+response.video_id+"?autohide=1&controls=1&showinfo=1";
            player=`<iframe
                                    id="playingVideo"
                                    class="embed-responsive-item"
                                    src="${url}"
                                    frameborder="0"
                                    width="100%"
                                    allowfullscreen
                                    style="min-width: 30vw;min-height: 30vh;">

                             </iframe>`;
        }
        else if(response.player == "vimeo"){
            url = "https://player.vimeo.com/video/"+response.video_id+"?portrait=0";
            player=`<iframe
                                    id="playingVideo"
                                    class="embed-responsive-item"
                                    src="${url}"
                                    frameborder="0"
                                    width="100%"
                                    allowfullscreen
                                    style="min-width: 30vw;min-height: 30vh;">

                             </iframe>`;
        }
        else if(response.player == "dailymotion"){
            url = "https://www.dailymotion.com/embed/video/"+response.video_id;
            player=`<iframe
                                    id="playingVideo"
                                    class="embed-responsive-item"
                                    src="${url}"
                                    frameborder="0"
                                    width="100%"
                                    allowfullscreen
                                    style="min-width: 30vw;min-height: 30vh;">

                             </iframe>`;
        }
        else if(response.player == "vidyard")
        {
            player=`<iframe 
                class="vidyard_iframe embed-responsive-item"
                id="playingVideo"
                src="//play.vidyard.com/${response.video_id}.html?" 
                width="100%" scrolling="no" 
                frameborder="0" 
                allowtransparency="true" 
                allowfullscreen
                style="min-width: 30vw;min-height: 30vh;">
                </iframe>`;
        }
        
        else if(response.player == "zoom")
        {
            player=`<div class="text-center text-white align-self-center">
                <p><a href="${response.video_id}" target="_blank" class="btn btn-danger" style="background-color:red">Click Here To Play The Zoom Video</a></p>
            </div>`;
        }

        else if(response.player == "uploaded"){
            url = response.video_id;
            player=`<video
                        id="playingVideo"
                        class="embed-responsive-item"
                        width="100%"
                        height="100%"
                        src="${url}"
                        allowfullscreen
                        controls
                        controlsList="nodownload"
                        allowseeking
                        nodownload>

                        </video>`;
        }
        return player;
    }


});


//home page player
$(document).ready(function(){
    $('.play_video_btn').click(function(){
        console.log('hello');
        $('#video_iframe').attr('src','');
        let videoID = $(this).attr('video-id');
        let src= "https://www.youtube.com/embed/"+videoID+"?autohide=1&controls=1&showinfo=1";
        $('#video_iframe').attr('src',src);
    });
});
