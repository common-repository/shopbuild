;(function($){
    "use strict";

    const init = function(){
        renderPopup();
        $('body.post-type-pure_wc_template #wpcontent').on('click', '.page-title-action, .row-title, .row-actions .edit > a', openPopup);
        $('body.post-type-pure_wc_template').on('click', '.sb-offcanvas-close-btn, .sb-body-overlay', closePopup);
        $('body.post-type-pure_wc_template').on('click', '#pure-wc-save-template', saveTemplate);
        $('body.post-type-pure_wc_template').on('change', '#template_type', onTypeChange);
        // $('body.post-type-pure_wc_template').on('click', '.sb-templ-demo-box', toggleCheckbox);
    }
    const openPopup = function(event){
        event.preventDefault();
        
        
        var rowID = $(this).closest('tr').attr('id'),
            editorLink = null,
            tmplID = null;
        if(rowID){
            tmplID = rowID.replace('post-', '');
            editorLink = 'post.php?post='+tmplID+'&action=elementor';
            $('.sb-offcanvas-btn-reset').addClass('active').attr('href', editorLink);
            $( '#pure-wc-shopbuild-tmpl-popup > .sb-offcanvas-area' ).attr('data-post', tmplID);
           
            $.ajax({
                type:'POST',
                url:PURE_WC_SHOPBUILD.ajax_url,
                data:{
                    action: 'pure_wc_shopbuild_get_template',
                    ID: tmplID,
                    security: PURE_WC_SHOPBUILD.template_get_nonce
                },
                success:function(response){
                    // console.log(response.data.type, PURE_WC_SHOPBUILD.templates);
                    var newPopup = wp.template( 'pure-wc-shopbuild' ),
                        content = null,
                        data = {
                            tmpltypes:PURE_WC_SHOPBUILD.types,
                            heading:"Template Settings",
                            library:PURE_WC_SHOPBUILD.templates.filter( tmpl => tmpl.type == response.data.type ),
                            post_url:PURE_WC_SHOPBUILD.admin_post_url,
                            tmplid:tmplID,
                            editor_link:'',
                            api_url: PURE_WC_SHOPBUILD.api_url,
                            templ_error_msg:'Please give a template name!',
                            type_error_msg:'Please select a template type!'
                        };

                    content = newPopup(data);

                    $( '#pure-wc-shopbuild-tmpl-popup' ).html( content );
                    
                    $('#pure-wc-shopbuild-tmpl-popup > .sb-offcanvas-area').attr('data-post', tmplID);
                    setTimeout(function(){
                        $('#pure-wc-shopbuild-tmpl-popup > .sb-offcanvas-area').addClass('sb-offcanvas-opened');
                        $('.sb-body-overlay').addClass('opened');
                    }, 100);
                    
                    $('#template_name').val(response.data.title);
                    $('#template_type').val(response.data.type).trigger('change');
                    $('#template_type').niceSelect();
                    if(response.data.set_as == 'default'){
                        $('#set_as_default').prop('checked', true);
                    }else{
                        $('#set_as_default').prop('checked', false);
                    }
                    $('.sb-template-show-popup').purewcPopup({
                        gallery: {
                        enabled: false
                        },
                        type: 'image' // this is a default type
                    });
                }
            })

            $('#pure-wc-shopbuild-tmpl-popup').removeClass('sb-adding').addClass('sb-editing');
        }else{
            var popupTmp = wp.template( 'pure-wc-shopbuild' ),
            content = null,
            data = {
                tmpltypes:PURE_WC_SHOPBUILD.types,
                heading:"Template Settings",
                library:PURE_WC_SHOPBUILD.templates,
                old_library:PURE_WC_SHOPBUILD.old_templates,
                post_url:PURE_WC_SHOPBUILD.admin_post_url,
                tmplid:'',
                editor_link:'',
                api_url: PURE_WC_SHOPBUILD.api_url,
                templ_error_msg:'Please give a template name!',
                type_error_msg:'Please select a template type!'
            };

            content = popupTmp(data);
            $('#pure-wc-shopbuild-tmpl-popup').html( content );
            $('#template_type').niceSelect();
            setTimeout(function(){
                $('#pure-wc-shopbuild-tmpl-popup > .sb-offcanvas-area').addClass('sb-offcanvas-opened');
            }, 100);
            $('.sb-body-overlay').addClass('opened');
            $('.sb-template-show-popup').purewcPopup({
                gallery: {
                    enabled: false
                },
                type: 'image' // this is a default type
            });
            $('#pure-wc-shopbuild-tmpl-popup').addClass('sb-adding').removeClass('sb-editing');
        }
        
    }
    const closePopup = function(){
        $('#pure-wc-shopbuild-tmpl-popup > .sb-offcanvas-area').removeClass('sb-offcanvas-opened');
        $('.sb-body-overlay').removeClass('opened');
    }

    const toggleCheckbox = function(event){
        var $this = $(this),
            isChecked = $this.children('input').prop('checked');

        if(isChecked){
            $this.children('input').prop('checked', false);
            $this.removeClass('active');
        }else{
            $this.children('input').prop('checked', true);
            $this.addClass('active');
        }
    }
    // Render Popup HTML
    const renderPopup = function( newData = {} ){
        var popupTmp = wp.template( 'pure-wc-shopbuild' ),
            content = null,
            data = {
                tmpltypes:PURE_WC_SHOPBUILD.types,
                heading:"Template Settings",
                library:PURE_WC_SHOPBUILD.templates,
                old_library:PURE_WC_SHOPBUILD.old_templates,
                post_url:PURE_WC_SHOPBUILD.admin_post_url,
                tmplid:'',
                editor_link:'',
                api_url: PURE_WC_SHOPBUILD.api_url,
                templ_error_msg:'Please give a template name!',
                type_error_msg:'Please select a template type!'
            };

        content = popupTmp({ ...data, ...newData});

        $( '#pure-wc-shopbuild-tmpl-popup' ).html( content );

    }

    const onTypeChange = function(event){
        var type            = $(this).val(),
            tmplID          = $('#pure-wc-shopbuild-tmpl-popup > .sb-offcanvas-area').attr('data-post');

        $('.sb-templ-demo-box').each(function(ind, el){
            if($(el).hasClass(type)){
                $(el).show();
            }else{
                $(el).hide();
            }
        })
    }

    const saveTemplate = function(event){
        event.preventDefault();
        var templateName = $('#template_name').val(),
            templateType = $('#template_type').val(),
            setAsDefault = $('#set_as_default').prop('checked')? 'default' : 'inactive',
            tmplDemo     = '',
            tmplDemoID   = '',
            tmplID       = $('#pure-wc-shopbuild-tmpl-popup > .sb-offcanvas-area.sb-offcanvas-opened').attr('data-post');
      
        $('.sb-templ-demo-box input').each(function(ind, el){ 
            if($(el).prop('checked')){
                tmplDemo = $(el).val();
                tmplDemoID = $(el).attr('id');
            }
        });
        if(templateName.length == 0){
            $('#template_name').closest('.sb-offcanvas-option-action').find('.error').show(100);
            $('#template_name').css("border", "1px solid #f73b3d");
        }else{
            $('#template_name').closest('.sb-offcanvas-option-action').find('.error').hide(100);
            $('#template_name').css("border", "1px solid rgba(13, 4, 50, 0.12)");
        }
        if(templateType == -1){
            $('#template_type').closest('.sb-offcanvas-option-action').find('.error').show(100);
            $('#template_type').closest('.choices__inner').css("border", "1px solid #f73b3d");
            
        }else{
            $('#template_type').closest('.sb-offcanvas-option-action').find('.error').hide(100);
            $('#template_type').closest('.choices__inner').css("border", "1px solid rgba(13, 4, 50, 0.12)");
        }

        if( templateName.length > 0 && templateType != -1 ){
            $.ajax({
                type:'POST',
                url: PURE_WC_SHOPBUILD.ajax_url,
                data:{
                    action:'pure_wc_shopbuild_save_template',
                    security:PURE_WC_SHOPBUILD.template_nonce,
                    template_name:templateName,
                    template_type:templateType,
                    template_demo: tmplDemo,
                    template_demo_id: tmplDemoID,
                    template_id: tmplID,
                    set_as_default:setAsDefault
                },
                success:function(response){
                    if(response.success){
                        $.pure_wc_toastr.success('Post saved successfully.', {
                            position:'top-right',
                            time:1000
                        });
                        $('#pure-wc-shopbuild-tmpl-popup > .sb-offcanvas-area.sb-offcanvas-opened').attr('data-post', response.data.ID);
                        $('.sb-offcanvas-btn-reset').addClass('active').attr('href', response.data.editor_url);
                    }
                }
            })
        }
    }


    init();

    $('#template_type').niceSelect();

    $('.sb-template-show-popup').purewcPopup({
		gallery: {
		  enabled: true
		},
		type: 'image' // this is a default type
	});

    $(document).on('change', '.sb-templ-demo-box input', function(event){
        event.preventDefault();

        if($(this).closest('.sb-templ-demo-box').hasClass('active')){
            $(this).prop('checked', false);
            $(this).closest('.sb-templ-demo-box').removeClass('active');
        }else{
            $('.sb-templ-demo-box input').each(function(ind, el){
                $(el).prop('checked', false);
                $(el).closest('.sb-templ-demo-box').removeClass('active');
            });
            $(this).prop('checked', true);
            $(this).closest('.sb-templ-demo-box').addClass('active');
        }
        
    });
})(jQuery);
