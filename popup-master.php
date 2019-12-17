<?php

/**
 * Plugin Name: DriftWeb - Popup Master
 * Description: Plugin criar e gerenciar Popups no site.
 * Author: <a href="https://www.linkedin.com/in/marcelo-assun%C3%A7%C3%A3o-dos-santos-junior-19162317a/" _target='blank'>Marcelo Assunção</a> 
 * Version: 1.0.0
 */


if (!defined('ABSPATH')):
    exit();
endif;


define('POPUP_MASTER_PATH', plugin_dir_path(__FILE__));
define('POPUP_MASTER_URL', plugin_dir_url(__FILE__));

define('POPUP_MASTER_INCLUDES_PATH', plugin_dir_path(__FILE__) . 'includes/');
define('POPUP_MASTER_INCLUDES_URL', plugin_dir_url(__FILE__) . 'includes/');

define('POPUP_MASTER_VIEWS_PATH', plugin_dir_path(__FILE__) . 'views/');
define('POPUP_MASTER_VIEWS_URL', plugin_dir_url(__FILE__) . 'views/');

define('POPUP_MASTER_ASSETS_PATH', plugin_dir_path(__FILE__) . 'assets/');
define('POPUP_MASTER_ASSETS_URL', plugin_dir_url(__FILE__) . 'assets/');

define('POPUP_MASTER_PAGE_SLUG', 'popup_master');


if (!class_exists('popupMaster')):

    class popupMaster{

        /**
         * Instance of this class
         *
         * @var object
         */



        protected static $popupMaster = null;


        private function __construct(){
            /**
             * Include plugin files
             */

            $this->enqueue_includes();

            // $this->enqueue_views();
        
             /**
             * Add plugin Stylesheet and JavaScript, in frontend
             */         

            add_action('wp_enqueue_scripts', array(
                $this,
                'enqueue_scripts'
            ));

             /**
             * Add plugin Stylesheet and JavaScript, in admin
             */

            add_action('admin_enqueue_scripts', array(
                $this,
                'admin_enqueue_scripts'
            ));

        }





        public static function popup_master_start(){

            if (self::$popupMaster == null):

                self::$popupMaster = new self();

            endif;



            return self::$popupMaster;

        }


        private function enqueue_includes(){

            include_once POPUP_MASTER_INCLUDES_PATH . 'class-popup-master-admin.php';

        }

        public function enqueue_scripts(){

            wp_enqueue_script(
                'popup-master-js',
                POPUP_MASTER_ASSETS_URL . 'js/popup-master-js.js' );

            wp_localize_script( 'popup-master-js', 'ajax_object', array(
                'ajaxurl' => admin_url('admin-ajax.php')
            ) );

        }


        public function admin_enqueue_scripts(){
            if(isset($_GET["page"]) && $_GET["page"] == POPUP_MASTER_PAGE_SLUG){
                wp_enqueue_style(
                    'popup-master-admin-css',
                    POPUP_MASTER_ASSETS_URL . 'css/popup-master-admin-css.css'
                );

                wp_enqueue_script(
                    'popup-master-admin-js',
                    POPUP_MASTER_ASSETS_URL . 'js/popup-master-admin-js.js', array('jquery') );


                wp_localize_script( 'popup-master-admin-js', 'popup_master_object', array(
                    'ajaxurl' => admin_url('admin-ajax.php')
                ) );

                wp_enqueue_style(
                    'popup-master-admin-css-1', 'https://code.getmdl.io/1.3.0/material.indigo-pink.min.css'
                );
                wp_enqueue_style(
                    'popup-master-admin-css-2', 'https://fonts.googleapis.com/icon?family=Material+Icons'
                );

                wp_enqueue_script(
                    'popup-master-admin-js-1', 'https://code.getmdl.io/1.3.0/material.min.js'
                );

                wp_enqueue_media();
                wp_enqueue_style( 'wp-color-picker');
                wp_enqueue_script( 'wp-color-picker-alpha',  POPUP_MASTER_ASSETS_URL . 'js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ) );
            }
        }


    } 
    

    add_action('plugins_loaded', array('popupMaster', 'popup_master_start'));


endif;