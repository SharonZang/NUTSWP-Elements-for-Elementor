jQuery(document).ready(function ($) {
    // 动态设置视频尺寸
    function setVideoSize() {
        $('.nutswp-bilibili-video').each(function () {
            var $video = $(this);
            var widthDesktop = $video.data('width-desktop');
            var widthTablet = $video.data('width-tablet');
            var widthMobile = $video.data('width-mobile');
            var heightDesktop = $video.data('height-desktop');
            var heightTablet = $video.data('height-tablet');
            var heightMobile = $video.data('height-mobile');

            if (window.innerWidth <= 767) {
                $video.css({
                    'width': widthMobile,
                    'height': heightMobile
                });
            } else if (window.innerWidth <= 1024) {
                $video.css({
                    'width': widthTablet,
                    'height': heightTablet
                });
            } else {
                $video.css({
                    'width': widthDesktop,
                    'height': heightDesktop
                });
            }
        });
    }

    // 初始化设置
    setVideoSize();

    // 窗口大小变化时重新设置
    $(window).on('resize', function () {
        setVideoSize();
    });

    // 点击封面图播放视频
    $('.nutswp-bilibili-video .video-cover').on('click', function () {
        var $video = $(this).siblings('iframe');
        var src = $video.attr('src');
        if (!src.includes('autoplay=1')) {
            $video.attr('src', src + '&autoplay=1');
        }
        $(this).fadeOut(); // 隐藏封面图
    });
});