(function($){

    function setVideoSize(popup, size, callback){
        let container = popup.find('.popup-wrapper');
        let wrapper = popup.find('.video-wrapper');
        let video = popup.find('video');

        let window_width = $(window).outerWidth() - 60;
        let window_height = $(window).outerHeight() - 150;

        let css = [];

        if(window_height >= size.height && window_width >= size.width){
            css = {
                width: size.width,
                height: size.height
            }
        }else{
            if(window_height < size.height){
                css = {
                    width: size.width * window_height / size.height,
                    height: window_height,
                };
            }else if(window_width < size.width){
                css = {
                    height: size.height * window_width / size.width,
                    width: window_width,
                };
            }else{
                if(size.height / window_height > size.width / window_width){
                    css = {
                        width: size.width * window_height / size.height,
                        height: window_height,
                    };
                }else{
                    css = {
                        height: size.height * window_width / size.width,
                        width: window_width,
                    };
                }
            }

        }

        container.css(css);
        wrapper.css(css);
        video.css(css);

        setTimeout(callback, 0);
    }

    $(document).ready(function(){
        $(".popup .popup-close").click(function(e){
            e.preventDefault();

            let popup = $(this).closest('.popup');

            popup.fadeOut(500, function(){

                let video = popup.find('video');
                let container = popup.find('.popup-wrapper');
                let wrapper = popup.find('.video-wrapper');

                let css = {
                    width: '100%',
                    height: '100%'
                }

                container.css(css);
                wrapper.css(css);
                video.css(css);

                popup.find('video').remove();
            });
        });
        $(".popup-trigger").click(function(e){
            e.preventDefault();

            let url = $(this).attr('href');

            let popup = $($(this).attr('data'));

            let container = popup.find('.popup-wrapper');
            let wrapper = popup.find('.video-wrapper');
            wrapper.html('');

            let video = $('<video></video>');
            video.attr({
                loop: false,
                controls: '',
                autoplay: ''
            });

            video.append($('<source></source>')
                .attr({
                    type: 'video/webm',
                    src: url
                })
            )
            video.append($('<source></source>')
                .attr({
                    type: 'video/mp4',
                    src: url
                })
            )


            wrapper.append(video);


            setTimeout(function(){
                video[0].oncanplay = function(){

                    let size = {
                        width: this.offsetWidth,
                        height: this.offsetHeight
                    }
                    console.log(size);
                    setVideoSize(
                        popup, size, function(){}
                    );
                };
            }, 0)


            popup.fadeIn(500);

        });
    })

})(jQuery)
