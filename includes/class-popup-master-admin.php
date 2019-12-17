<?php



if (!defined('ABSPATH')):

    exit();

endif;


if (!class_exists('classPopupMaster')):


    class classPopupMaster{


        public function __construct(){
            add_action('admin_menu', array($this, 'addMenuPopupMasters'), 99999 );
            add_action('wp_head', array($this,'head_popup_master'));
        }

        function head_popup_master() {    
            echo $this->generate_popup_master();
        }
        

        public function addMenuPopupMasters(){            

            $page_title = 'Drift Popups';
            $menu_title = 'Drift Popups';
            $capability = 'manage_options';
            $menu_slug  = POPUP_MASTER_PAGE_SLUG;
            $function   = array($this,'popup_master_html');
            $icon_url   = 'dashicons-testimonial';
            $position   = 4;

            add_menu_page( $page_title,
                            $menu_title, 
                            $capability, 
                            $menu_slug, 
                            $function, 
                            $icon_url, 
                            $position );

        }

        public function popup_master_html(){

            if(!empty($_POST)){
                update_option('popup-master-options', $_POST);
            }
            $dados = get_option( 'popup-master-options' );
            ?>
            
            <h2>Popup Mestre</h2>
            <section id="popup-master">
            <form action="" method="post">
                <div class="container-popup">
                    <input type='hidden' value='' name='popup-master-status'>
                    <label for="popup-master-status">Ativar Popup?</label>
                    <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="popup-master-status">
                        <input type="checkbox" name="popup-master-status" id="popup-master-status" class="mdl-switch__input" <?php echo ($dados['popup-master-status'] ? 'checked' : ''); ?>>
                        <span class="mdl-switch__label"></span>
                    </label>
                </div>           

                <div class="container-popup">
                    <label for="tipo-medidas-popup">Tipo Medidas popup: </label>
                        <div class="lista-coluna">

                            <?php 
                            $array_medida_popup = [];
                            $array_medida_popup[] = ['id' => 'tipo-medida-popup-pixels', 'placeholder' => 'Pixels', 'name' => 'tipo-medidas-popup', 'value' => 'px'];                    
                            $array_medida_popup[] = ['id' => 'tipo-medida-popup-porcentagem', 'placeholder' => 'Porcentagem', 'name' => 'tipo-medidas-popup', 'value' => '%'];                    
                            $array_medida_popup[] = ['id' => 'tipo-medida-popup-auto', 'placeholder' => 'Automático', 'name' => 'tipo-medidas-popup', 'value' => 'auto'];
                            foreach ($array_medida_popup as $key => $medida) {
                                echo $this->popup_radio_field($medida['name'], $medida['id'], $medida['placeholder'], $medida['value'], (isset($dados['tipo-medidas-popup']) && $dados['tipo-medidas-popup'] == $medida['value'] ? true : null));
                            }
                            ?>
                        </div>
                </div>

                <div class="container-popup lista-dim">
                    <?php

                    $array_dim_popup = [];
                    $array_dim_popup[] = ['id' => 'altura-popup', 'placeholder' => 'Altura', 'name' => 'altura-popup'];                    
                    $array_dim_popup[] = ['id' => 'largura-popup', 'placeholder' => 'Largura', 'name' => 'largura-popup'];
                    // $array_dim_popup[] = ['id' => 'altura-min-popup', 'placeholder' => 'Altura Mínima(px)', 'name' => 'altura-min-popup'];
                    // $array_dim_popup[] = ['id' => 'largura-min-popup', 'placeholder' => 'Largura Mínima(px)', 'name' => 'largura-min-popup'];
                    foreach ($array_dim_popup as $key => $dim) {
                        echo $this->popup_number_field($dim['name'], $dim['id'], $dim['placeholder'], (isset($dados[$dim['id']]) ? $dados[$dim['id']] : ''));
                    }
                        
                    ?>
                </div>

                <div class="container-popup">
                    <?php
                    echo $this->popup_text_field('popup-master-border', 'popup-master-border', 'Borda css(inline)', $dados['popup-master-border']);
                    ?>
                </div>

                <div class="container-popup">
                    <input type='hidden' value='' name='popup-master-exit'>
                    <label for="popup-master-exit">Permitir fechar?</label>
                    <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="popup-master-exit">
                        <input type="checkbox" name="popup-master-exit" id="popup-master-exit" class="mdl-switch__input" <?php echo (isset($dados['popup-master-exit']) && $dados['popup-master-exit'] ? 'checked' : ''); ?>>
                        <span class="mdl-switch__label"></span>
                    </label>
                </div>


                <div class="container-popup">
                    <input type='hidden' value='' name='popup-master-fundo'>
                    <label for="popup-master-fundo">Cor fundo popup</label>
                    <input class="color_field color-picker" data-alpha="true" type="hidden" name="popup-master-fundo" value="<?php echo (isset($dados['popup-master-fundo']) && $dados['popup-master-fundo'] ? $dados['popup-master-fundo'] : '') ?>"/>
                </div>

                <div class="container-popup data">
                    <span>
                        <label for="popup-master-data-inicial">Data Inicial</label>
                        <input type="date" name="popup-master-data-inicial" id="popup-master-data-inicial" value="<?php echo (isset($dados['popup-master-data-inicial']) ? $dados['popup-master-data-inicial'] : '')?>">
                    </span>
                    <span>
                        <label for="popup-master-data-final">Data Final</label>
                        <input type="date" name="popup-master-data-final" id="popup-master-data-final" value="<?php echo (isset($dados['popup-master-data-final']) ? $dados['popup-master-data-final'] : '')?>">
                    </span>
                <?php
                echo $this->popup_number_field('popup-master-freq', 'popup-master-freq', 'Frequência (em minutos)', $dados['popup-master-freq']);
                ?>
                </div>


                <h4>Configurações Imagem</h4>

                <div class="container-popup imagem">
                    <input type="button" name="upload_imagem_popup" id="upload_imagem_popup" class="button-secondary" value="Selecione uma imagem">
                    <input type="hidden" id="url-imagem-popup" name="url-imagem-popup" value="<?php echo (isset($dados['url-imagem-popup']) && $dados['url-imagem-popup'] ? $dados['url-imagem-popup'] : '') ?>">
                    <div class="imagem-preview">
                        <span>Selecione uma imagem +</span>
                        <img src="<?php echo (isset($dados['url-imagem-popup']) && $dados['url-imagem-popup'] ? $dados['url-imagem-popup'] : '') ?>" id="imagem-preview-popup-master">
                    </div>
                    <span class="delete-imagem">X</span>
                </div>

                <div class="container-popup">
                    <?php
                    $link_imagem = '';
                    echo $this->popup_text_field('link-imagem', 'link-imagem', 'Link', (isset($dados['link-imagem']) && $dados['link-imagem'] ? $dados['link-imagem'] : ''));
                    ?>
                </div>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                Salvar
                </button>
                </form>
            </section>
            <?php
        }




        public function popup_text_field($name = null, $id = null, $placeholder = null, $value = null){
            if($name){
                $name = 'name="'.$name.'"';
            }
            $for = $id;
            if($id){
                $id = 'id="'.$id.'"';
                $for = 'for="'.$for.'"';
            }
            if($value){
                $value = 'value="'.$value.'"';
            }
            return '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" '.$name.' type="text" '.$id.' '.$value.'>
            <label class="mdl-textfield__label" '.$for.'>'.$placeholder.'</label>
          </div>';
        }
        
        public function popup_number_field($name = null, $id = null, $placeholder = null, $value = null){
            if($name){
                $name = 'name="'.$name.'"';
            }
            $for = $id;
            if($id){
                $id = 'id="'.$id.'"';
                $for = 'for="'.$for.'"';
            }
            if($value){
                $value = 'value="'.$value.'"';
            }
            return '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label popup">
            <input class="mdl-textfield__input" type="text" '.$name.' pattern="-?[0-9]*(\.[0-9]+)?" '.$id.' '.$value.'>
            <label class="mdl-textfield__label" '.$for.'>'.$placeholder.'</label>
          </div>';
        }
        
        public function popup_radio_field($name = null, $id = null, $placeholder = null, $value = null, $checked = null){
            if($name){
                $name = 'name="'.$name.'"';
            }
            $for = $id;
            if($id){
                $id = 'id="'.$id.'"';
                $for = 'for="'.$for.'"';
            }
            if($value){
                $value = 'value="'.$value.'"';
            }
            if($checked){
                $checked = 'checked';
            }
            return '<label style="padding-left: 18px;margin-right: 14px;" class="mdl-radio mdl-js-radio mdl-js-ripple-effect" '.$for.'>
            <input type="radio" '.$id.' class="mdl-radio__button" '.$name.' '.$value.' '.$checked.'>
            <span class="mdl-radio__label">'.$placeholder.'</span>
          </label>';
        }

        public function generate_popup_master(){
            $dados = get_option( 'popup-master-options' );
            if($dados['popup-master-status'] != 'on'){
                return;
            }
            date_default_timezone_set('America/Sao_Paulo');
            $data_atual = time();
            $mostra_popup = false;
            if($data_atual >= strtotime($dados['popup-master-data-inicial']) && $data_atual <= strtotime($dados['popup-master-data-final'])){
                $data_freq = (isset($_COOKIE['popup-master-freq']) ? $_COOKIE['popup-master-freq'] : 0);
                $valor_data_freq_cookie = (isset($_COOKIE['popup-master-freq-valor']) ? $_COOKIE['popup-master-freq-valor'] : 0);
                if(strtotime( $data_atual ) >= $data_freq || $dados['popup-master-freq'] != $valor_data_freq_cookie ){
                    // echo $data_freq;
                    $mostra_popup = true;
                    $dados_freq = $dados['popup-master-freq'];
                    settype($data_atual, 'integer');
                    settype($dados_freq, 'integer');
                    $data_freq = $data_atual + ($dados_freq * 60);
                    setcookie("popup-master-freq", $data_freq, $data_freq, "/");
                    setcookie("popup-master-freq-valor", $dados['popup-master-freq'], time()+31556926, "/");//valor usado para verificar o tempo usado no cookie e salvo na option do site
                }
            }
            if(!$mostra_popup){
                return;
            }
            if($dados['tipo-medidas-popup'] == 'px'){
                $uni_med_w = 'px';
                $uni_med_h = 'px';
            }else{
                $uni_med_w = 'vw';
                $uni_med_h = 'vh';
            }
            $altura = $dados['altura-popup'];
            $largura = $dados['largura-popup'];
            $auto = false;
            if($dados['tipo-medidas-popup'] == 'auto'){
                $auto = true;
                $altura = $largura = $uni_med_h = $uni_med_w = '';
            }
            $html = '<style>
            .popup-master-fundo {
                width: 100%;
                height: 100%;
                position: fixed;
                '.($dados['popup-master-fundo'] ? "background: ".$dados['popup-master-fundo'] : "").';
                z-index: 9999999;
                top: 0;
                left: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        
            div#popup-master::-webkit-scrollbar {
                background-color: transparent;
                
                width: 8px;
            }
            
            div#popup-master::-webkit-scrollbar-track {
                background-color: transparent;
                width: 5px;
            }
            div#popup-master::-webkit-scrollbar-track:hover {
                background-color: #a2a2a23d
            }
            
            div#popup-master::-webkit-scrollbar-thumb {
                width: 1px;
                background: grey;
              border-radius: 10px;
              border-right: 1px solid transparent;
            }
            div#popup-master::-webkit-scrollbar-thumb:hover {
                background-color:#a0a0a5;
            }
            
            div#popup-master::-webkit-scrollbar-button {display:none}
        
            div#popup-master {
                '.($auto ? 'height: auto;
                max-height: 100vh;
                max-width: 100vw;
                width: auto;' 
                : 'max-height: '.$altura.$uni_med_h.';
                width: '.$largura.$uni_med_w.';').'
                
                overflow-y: scroll;
                position: relative;
            }
            
            div#popup-master a {
                width: 100%;
                height: 100%;
            }
            
            div#popup-master img {
                width: 100%;
                height: auto;
                '.$dados['popup-master-border'].'
            }
            span.delete-imagem {
                position: absolute;
                right: 0px;
                top: 0px;
                z-index: 2;
                font-size: 20px;
                background: white;
                padding: 5px;
                font-weight: 600;
                border-radius: 0% 0% 0% 50%;
            }
            </style>';
        
        
            $html .= '<div class="popup-master-fundo">
                        <div id="popup-master">
                            <a href="'.$dados['link-imagem'].'">
                                <img src="'.$dados['url-imagem-popup'].'">
                            </a>
                            '.($dados['popup-master-exit'] ? '<span class="delete-imagem">X</span>' : '').'                   
                        </div>
                    </div>';
                    return $html;
        }

    }



    $classPopupMaster = new classPopupMaster();



endif;