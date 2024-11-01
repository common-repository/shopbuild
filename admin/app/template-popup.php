<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    $template_html = '
    <div class="sb-offcanvas-area" data-post="{{ data.tmplid }}">
        <div class="sb-offcanvas-wrapper sb-d-flex sb-flex-column sb-justify-content-between">
            <div class="sb-offcanvas-main">
                <div class="sb-offcanvas-header sb-d-flex sb-align-items-center">
                    <button class="sb-offcanvas-close-btn"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </svg></button>
                    <p>{{{ data.heading }}}</p>
                </div>
                <div class="sb-offcanvas-content">
                    <div class="sb-offcanvas-option-item">
                        <div class="sb-offcanvas-option-content">
                            <h4 class="sb-offcanvas-option-title">Name</h4>
                            <p>Your template title for the template.</p>
                        </div>
                        <div class="sb-offcanvas-option-action">
                            <div class="sb-offcanvas-input">
                                <input type="text" id="template_name" name="template_name" placeholder="Template Title...">
                            </div>
                            <p class="error" style="display:none">{{ data.templ_error_msg }}</p>
                        </div>
                    </div>
                    
                    <div class="sb-offcanvas-option-item">
                        <div class="sb-offcanvas-option-content">
                            <h4 class="sb-offcanvas-option-title">Type</h4>
                            <p>Select a template type for the template</p>
                        </div>
                        <div class="sb-offcanvas-option-action">
                            <div class="sb-offcanvas-select sb-position-select sb-settings-option-select sb-common-select">
                                <select name="template_type" id="template_type" class="wide">
                                    <option value="-1">No Type Selected</option>
                                    <# 
                                        _.each(data.tmpltypes, (type, key)=>{
                                            #>
                                                <option value="{{ type.value }}">{{ type.label }}</option>
                                            <#
                                        });
                                    #>
                                </select>
                            </div>
                            <p class="error" style="display:none">{{ data.type_error_msg }}</p>
                        </div>
                    </div>
                    
                    <div class="sb-offcanvas-option-item sb-d-flex sb-align-items-center sb-justify-content-between sb-flex-wrap">
                        <div class="sb-offcanvas-option-content">
                            <h4 class="sb-offcanvas-option-title font-semibold">Set as default</h4>
                            <p>If you set this template as default then it will override as default template.</p>
                        </div>
                        <div class="sb-offcanvas-option-action">
                            <div class="sb-toggle-switch-2">
                                <label for="set_as_default">
                                    <input type="checkbox" name="set_as_default" class="switch-input" id="set_as_default" checked>
                                    <span class="sb-toggle-switch-2-text on">Yes</span>
                                    <span class="sb-toggle-switch-2-text off">No</span>
                                    <span class="sb-toggle-switch-2-bg"></span>
                                    <span class="sb-toggle-switch-2-handle"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="sb-offcanvas-option-item sb-d-flex sb-justify-content-between sb-flex-wrap sb-library">
                        <# _.each(data.library, ( content, key) => { #>
                            <label class="sb-templ-demo-box {{ content.type }} {{ content.isActive == true? \'active\' : \'\' }}">
                            <# if(content.isPro == false){ #>
                                <# if(content.isActive == true){ #>
                                <input type="checkbox" name="shopbuild_template" value="{{data.api_url +\'contents/\'+ content.path}}" id="{{ content.id }}" checked>
                                <# }else{ #>
                                <input type="checkbox" name="shopbuild_template" value="{{data.api_url +\'contents/\'+ content.path}}" id="{{ content.id }}">
                                <# } #>
                            <# } #>
                                <span class="sb-check"></span>
                                <div class="sb-templ-demo-thumbnail">
                                    <img src="{{data.api_url + \'previews/\' +content.thumbnail}}" alt="{{content.title}}">
                                    <# if(content.isPro == true) { #>
                                        <span class="badge is-pro">Pro</span>
                                    <# } #>

                                    <# if(content?.liveLink?.length > 0) { #>
                                   <div class="sb-templ-demo-livelink">
                                        <a href="{{ content?.liveLink }}" target="_blank" class="view-live">
                                            Live Demo 
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 9L9 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M1 1H9V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                   </div>
                                   <# }else{ #>
                                    <div class="sb-templ-demo-livelink">
                                       <a href="{{data.api_url + \'previews/\' +content.thumbnail}}" class="sb-template-show-popup view-popup">
                                            View Demo
                                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.50024 10C5.01496 10 3.00024 7.98528 3.00024 5.5C3.00024 3.01472 5.01496 1 7.50024 1C9.98553 1 12.0002 3.01472 12.0002 5.5C12.0002 7.98528 9.98553 10 7.50024 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M1 12L4 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                   </div>
                                    <# } #>
                                </div>
                                <h4>{{content.title}}</h4>
                            </label>
                        <# }) #>
                    </div>
                </div>
            </div>
            <div class="sb-offcanvas-footer">
                <div class="sb-offcanvas-footer-btn-wrapper sb-d-sm-flex sb-align-items-center">
                    <a href="{{ data.tmplid.length? data.post_url + \'?post=\' + data.tmplid + \'&action=elementor\' : \'#\' }}" class="{{ data.tmplid.length? \'sb-offcanvas-btn-reset active\' : \'sb-offcanvas-btn-reset\' }}">Edit With Elementor</a>
                    <a href="#" class="sb-offcanvas-btn-fill" id="pure-wc-save-template">Save Template</a>
                </div>
            </div>
        </div>
    </div>
    <div class="sb-body-overlay"></div>
    ';

    wp_print_inline_script_tag( $template_html, array(
        'type'  => 'text/html',
        'id'    => 'tmpl-pure-wc-shopbuild',
    ));
?>