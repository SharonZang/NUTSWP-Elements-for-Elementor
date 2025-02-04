<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Elementor_Bilibili_Video_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'bilibili_video';
    }

    public function get_title() {
        return __('Bilibili Video', 'nutswp-elements');
    }

    public function get_icon() {
        return 'eicon-youtube';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {
        // 视频ID
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'nutswp-elements'),
            ]
        );

        $this->add_control(
            'video_id',
            [
                'label' => __('Bilibili Video ID', 'nutswp-elements'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'BV1xxxxxx',
                'description' => __('Enter the Bilibili video ID (e.g., BV1xxxxxx).', 'nutswp-elements'),
            ]
        );

        $this->end_controls_section();

        // 自动播放
        $this->start_controls_section(
            'section_autoplay',
            [
                'label' => __('Autoplay', 'nutswp-elements'),
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'nutswp-elements'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nutswp-elements'),
                'label_off' => __('No', 'nutswp-elements'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->end_controls_section();

        // 视频尺寸
        $this->start_controls_section(
            'section_size',
            [
                'label' => __('Video Size', 'nutswp-elements'),
            ]
        );

        // 响应式宽度设置
        $this->add_responsive_control(
            'width',
            [
                'label' => __('Width', 'nutswp-elements'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1200,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 640,
                ],
                'devices' => ['desktop', 'tablet', 'mobile'], // 支持桌面、平板、手机
                'desktop_default' => [
                    'unit' => 'px',
                    'size' => 640,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
            ]
        );

        // 响应式高度设置
        $this->add_responsive_control(
            'height',
            [
                'label' => __('Height', 'nutswp-elements'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 360,
                ],
                'devices' => ['desktop', 'tablet', 'mobile'], // 支持桌面、平板、手机
                'desktop_default' => [
                    'unit' => 'px',
                    'size' => 360,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 280,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
            ]
        );

        $this->end_controls_section();

        // 封面图
        $this->start_controls_section(
            'section_cover',
            [
                'label' => __('Cover Image', 'nutswp-elements'),
            ]
        );

        $this->add_control(
            'cover_image',
            [
                'label' => __('Cover Image', 'nutswp-elements'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '', // 取消默认封面图
                ],
            ]
        );

        $this->add_control(
            'cover_size',
            [
                'label' => __('Cover Size', 'nutswp-elements'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'cover' => __('Cover', 'nutswp-elements'),
                    'contain' => __('Contain', 'nutswp-elements'),
                ],
                'default' => 'cover',
            ]
        );

        $this->end_controls_section();

        // 播放按钮
        $this->start_controls_section(
            'section_play_button',
            [
                'label' => __('Play Button', 'nutswp-elements'),
            ]
        );

        $this->add_control(
            'play_button_icon',
            [
                'label' => __('Play Button Icon', 'nutswp-elements'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-play',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'play_button_color',
            [
                'label' => __('Icon Color', 'nutswp-elements'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .play-button i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'play_button_bg_color',
            [
                'label' => __('Background Color', 'nutswp-elements'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.5)',
                'selectors' => [
                    '{{WRAPPER}} .play-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $video_id = $settings['video_id'];
        $autoplay = $settings['autoplay'] === 'yes' ? '1' : '0';
        $cover_image = $settings['cover_image']['url'];
        $cover_size = $settings['cover_size'];
        $play_button_icon = $settings['play_button_icon'];

        // 获取响应式宽度和高度
        $width_desktop = isset($settings['width']['size']) ? $settings['width']['size'] . $settings['width']['unit'] : '640px';
        $width_tablet = isset($settings['width']['tablet']) ? $settings['width']['tablet'] . $settings['width']['unit'] : '500px';
        $width_mobile = isset($settings['width']['mobile']) ? $settings['width']['mobile'] . $settings['width']['unit'] : '300px';

        $height_desktop = isset($settings['height']['size']) ? $settings['height']['size'] . $settings['height']['unit'] : '360px';
        $height_tablet = isset($settings['height']['tablet']) ? $settings['height']['tablet'] . $settings['height']['unit'] : '280px';
        $height_mobile = isset($settings['height']['mobile']) ? $settings['height']['mobile'] . $settings['height']['unit'] : '200px';

        // 生成Bilibili视频嵌入URL
        $embed_url = 'https://player.bilibili.com/player.html?bvid=' . esc_attr($video_id) . '&autoplay=' . esc_attr($autoplay);

        echo '<div class="nutswp-bilibili-video" data-width-desktop="' . esc_attr($width_desktop) . '" data-width-tablet="' . esc_attr($width_tablet) . '" data-width-mobile="' . esc_attr($width_mobile) . '" data-height-desktop="' . esc_attr($height_desktop) . '" data-height-tablet="' . esc_attr($height_tablet) . '" data-height-mobile="' . esc_attr($height_mobile) . '">';
        
        // 如果有封面图，则显示封面图和播放按钮
        if (!empty($cover_image)) {
            echo '<div class="video-cover" style="background-image: url(' . esc_url($cover_image) . '); background-size: ' . esc_attr($cover_size) . ';">';
            echo '<div class="play-button">';
            \Elementor\Icons_Manager::render_icon($play_button_icon, ['aria-hidden' => 'true']);
            echo '</div>';
            echo '</div>';
        }
        
        echo '<iframe src="' . esc_url($embed_url) . '" frameborder="0" allowfullscreen></iframe>';
        echo '</div>';
    }
}