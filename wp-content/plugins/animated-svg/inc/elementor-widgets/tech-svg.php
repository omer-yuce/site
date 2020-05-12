<?php

namespace Elementor;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tech_Svg extends Widget_Base {
		
	public function get_name() {
		return 'tech-svg';
	}

    public function get_title() {
        return __('Technology Icons', 'animatesvg');
    }

    public function get_icon() {
        return 'fa fa-rss-square';
    }

    public function get_categories() {
        return array('animated-svg');
    }

	public function get_script_depends() {
		return ['animated-drwsvg'];
	}
	
	
    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'animatesvg' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'select_svg_option',
			[
				'label' => __( 'Select option', 'animatesvg' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'svg_icons',
				'options' => [
					'svg_icons'  => __( 'Tech icon library', 'animatesvg' ),
					'image' => __( 'Upload your icon', 'animatesvg' ),
				],
			]
		);
		
		$this->add_control(
			'svg_d_icon',
			[
				'label' => __( 'Select SVG icon', 'animatesvg' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tech_browser.svg',
				'options' => asvg_tech_icons_list(),
				'condition' => [
					'select_svg_option' => 'svg_icons',					
				],
			]
		);
		
		$this->add_control(
			'svg_image',
			[
				'label' => __( 'Choose SVG', 'animatesvg' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => [
					'select_svg_option' => 'image',
				],
			]
		);
		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'animatesvg' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'animatesvg' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'animatesvg' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'animatesvg' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_animated_svg-an' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'on_hover_draw',
			[
				'label' => __( 'Animate on hover?', 'animatesvg' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Enable', 'animatesvg' ),
				'label_off' => __( 'Disable', 'animatesvg' ),
				'return_value' => 'yes',
				'default' => 'yes',
				
			]			
          );	
	
		$this->add_control(
			'link-txt',
			[
				'label' => __( 'Link (applies to entire column)', 'animatesvg' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
        'column_link',
        [
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
				'active' => false,
				],
				'placeholder' => __( 'Add http:// for external URL', 'animatesvg' ),
				'selectors'   => [
				],
				]
      );
	  
	  	$this->add_control(
			'addons',
			[
				'label' => __( '<span style="font-size: 12px; font-style: normal; line-height: 1.4"><span style="font-size: 12px; font-style: normal;">New icons are being added frequently.<br>Visit the <a href="/wp-admin/admin.php?page=asvg-menu-addons" target="_blank"><span style="color: #f2295b;"><strong>Add-Ons</strong></span></a> page for the latest updates.</span>' ),
				'separator' => 'before',	
				'type' => Controls_Manager::RAW_HTML,
			]
		);
			
		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_svg_styling',
            [
                'label' => __('SVG Style', 'animatesvg'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );
		$this->add_control(
			'svg_type',
			[
				'label' => __( 'Animation style', 'animatesvg' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'delayed',
				'options' => asvg_svg_type(),
			]
		);
		$this->add_control(
            'duration',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => __('Duration', 'animatesvg'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 90,
				],
            ]
        );

		$this->add_responsive_control(
            'max_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => __('Maximum width of icon in pixels)', 'animatesvg'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 800,
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_animated_svg .svg_inner_block' => 'max-width: {{SIZE}}{{UNIT}};max-height:{{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_control(
			'border_stroke_color',
			[
				'label' => __( 'Stroke color', 'animatesvg' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'purple',
			]
		);
		
		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => __( 'Padding (in pixels)', 'animatesvg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors' => [
					'{{WRAPPER}} .svg_inner_block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],			
			]
		);
		
		$this->add_control(
			'entrance_animation',
			[
				'label' => __( 'Entrance Animation', 'animatesvg' ),
				'type' => \Elementor\Controls_Manager::ANIMATION,
				'prefix_class' => 'animated ',
			]
		
				);
				
				
		$this->end_controls_section();

	}
	
	 protected function render() {
        $settings = $this->get_settings_for_display();
		$alignment=$settings["alignment"];
		$link = $settings['wrapper_link'];

		
			$animation_effects=$settings["animation_effects"];
			$animation_delay=$settings["animation_delay"]["size"];			
			if($animation_effects=='no-animation'){
				$animated_class = '';
				$animation_attr = '';
			}else{
				$animate_offset = '';
				$animation_attr = ' data-animate-type="'.esc_attr($animation_effects).'" data-animate-delay="'.esc_attr($animation_delay).'"';
				$animation_attr .= ' data-animate-offset="'.esc_attr($animate_offset).'"';
			if($settings["animation_duration_default"]=='yes'){
					$animate_duration=$settings["animate_duration"]["size"];
					$animation_attr .= ' data-animate-duration="'.esc_attr($animate_duration).'"';
				}
			if(!empty($settings["animation_out_effects"]) && $settings["animation_out_effects"]!='no-animation'){
					$animation_attr .= ' data-animate-out-type="'.esc_attr($settings["animation_out_effects"]).'" data-animate-out-delay="'.esc_attr($settings["animation_out_delay"]["size"]).'"';					
			if($settings["animation_out_duration_default"]=='yes'){						
						$animation_attr .= ' data-animate-out-duration="'.esc_attr($settings["animation_out_duration"]["size"]).'"';
					}
				}
			}

			if($settings['select_svg_option'] == 'image'){
				$svg_url = $settings['svg_image']['url'];
			}else{
				$svg_url = ASVG_IMGS.'/svg/'.esc_attr($settings["svg_d_icon"]); 
			}
			if($settings['box_border'] == 'yes'){
			$serice_box_border ='service-border-box';		
		}
			if($settings['border_stroke_color'] !=''){
				$border_stroke_color=$settings['border_stroke_color'];
			}else{
				$border_stroke_color='none';
			}
			$uid=uniqid('svg');
			$hover_draw='';
			if(!empty($settings['on_hover_draw']) && $settings['on_hover_draw']=='yes'){
				$hover_draw='plus-hover-draw-svg';
			}
			

		if ( isset( $settings['column_link'], $settings['column_link']['url'] ) && ! empty( $settings['column_link']['url'] ) ) {
        
		wp_enqueue_script( 'asvg-click' );

        $this->add_render_attribute( '_wrapper', 'class', 'make-column-clickable-elementor' );
        $this->add_render_attribute( '_wrapper', 'style', 'cursor: pointer;' );
        $this->add_render_attribute( '_wrapper', 'data-column-clickable', $settings['column_link']['url'] );
        $this->add_render_attribute( '_wrapper', 'data-column-clickable-blank', $settings['column_link']['is_external'] ? '_blank' : '_self' );
      }
	  
	  
			$animate_svg ='<div class="pt_plus_animated_svg-an"><div class="pt_plus_animated_svg_bkg"> <div class="pt_plus_animated_svg-overlay"><div class="pt_plus_animated_svg '.esc_attr($hover_draw).' '.esc_attr($alignment).' '.esc_attr($uid).' '.esc_attr($animated_class).'" '.$animation_attr.' data-id="'.esc_attr($uid).'" data-type="'.esc_attr($settings["svg_type"]).'" data-duration="'.esc_attr($settings['duration']['size']).'" data-stroke="'.esc_attr($border_stroke_color).'" data-fill_color="none">';
					$animate_svg .='<div class="svg_inner_block">';
					
			$animate_svg .='<div class="asvg"><object style="pointer-events: none;" id="'.esc_attr($uid).'" type="image/svg+xml" data="'.esc_url($svg_url).'" ></object></div>';
					$animate_svg .='</div>';
				$animate_svg .='</div>';
			$animate_svg .='</div>';
			$animate_svg .='</div>';
			$animate_svg .='</div>';
			
		echo $before_content.$animate_svg.$after_content;
	}
	

}
Plugin::instance()->widgets_manager->register_widget_type( new Tech_Svg() );