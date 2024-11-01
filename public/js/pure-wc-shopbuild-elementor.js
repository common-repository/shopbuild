;(function($){
    "use strict";
    
    // Intercept click event on locked widgets
    console.log('Pure WC ShopBuild Elementor JS loaded');

    var storebuildElementorEditorMode = {

        init: function(){
            // Promosion Widget
            if ( !storebuildPro.hasPro || !_.isEmpty( storebuildPro.proWidgets ) ){
                console.log('StoreBuild Pro Widgets are enabled');
                this.addPromutionWidget();
                this.handleDialogBox();
            }
        },

        getWidgetInfo: function( value, key ) {
            let widgetObj = storebuildPro.proWidgets.find(function (widget, index) {
                if ( widget[key] == value ) return true;
            });
            return widgetObj;
        },

        addPromutionWidget: function(){
            elementor.hooks.addFilter("panel/elements/regionViews", function (panel) {

                if ( storebuildPro.hasPro || _.isEmpty( storebuildPro.proWidgets ) ) return panel;

                let freeCategoryIndex,
                    proCategory     = "storebuild_pro",
                    elementsView    = panel.elements.view,
                    categoriesPannelView  = panel.categories.view,
                    widgets         = panel.elements.options.collection,
                    allCategories   = panel.categories.options.collection,
                    storebuildProcategroy = [];

                    _.each(storebuildPro.proWidgets, function (widget, index) {
                        widgets.add({ 
                            name: widget.name, 
                            title: widget.title, 
                            icon: widget.icon, 
                            categories: [proCategory], 
                            editable: !1 
                        });
                    });

                    widgets.each(function (widget) {
                        widget.get("categories")[0] === proCategory && storebuildProcategroy.push(widget);
                    });

                    freeCategoryIndex = allCategories.findIndex({
                        name: "storebuild-addons"
                    });

                    if( freeCategoryIndex === 0 ){
                        allCategories.add({ 
                            name: proCategory, 
                            title: wp.i18n.__("StoreBuild Addons",'storebuild'), 
                            icon: "storebuild-category-icon", 
                            defaultActive: 1, 
                            sort: !0, 
                            hideIfEmpty: !0, 
                            items: storebuildProcategroy, 
                            promotion: !1 
                        }, { at: freeCategoryIndex + 1 });
                    }else{
                        freeCategoryIndex && allCategories.add({ 
                            name: proCategory, 
                            title: wp.i18n.__("StoreBuild Pro",'storebuild'), 
                            icon: "storebuild-category-icon", 
                            defaultActive: 1, 
                            sort: !0, 
                            hideIfEmpty: !0, 
                            items: storebuildProcategroy, 
                            promotion: !1 
                        }, { at: freeCategoryIndex + 1 });
                    }

                return panel;

            });
        },

        handleDialogBox: function(){

            parent.document.addEventListener("mousedown", function (e) {
        
                let allWidgets = parent.document.querySelectorAll(".elementor-element--promotion");
                
                if ( allWidgets.length > 0 && !storebuildPro.hasPro ) {
                    for ( let i = 0; i < allWidgets.length; i++ ) {
                        if ( allWidgets[i].contains( e.target ) ) {

                            let promotionDialog = parent.document.querySelector("#elementor-element--promotion__dialog"),
                                icon = allWidgets[i].querySelector(".icon > i"),
                                widgetTitleWrap = allWidgets[i].querySelector(".title-wrapper > .title"),
                                widgetTitle = widgetTitleWrap.innerHTML,
                                widgetObject = storebuildElementorEditorMode.getWidgetInfo(widgetTitle, 'title'),
                                actionURL = widgetObject?.action_url,
                                widgetDescription = widgetObject?.description ? sprintf( widgetObject.description, widgetTitle ) : sprintf( wp.i18n.__('Use %s widget and dozens more pro features to extend your toolbox and build sites faster and better.', 'storebuild'), widgetTitle );


                            if ( icon.classList.contains('storebuild-pro-promotion') ) {

                                promotionDialog.classList.add('storebuild-pro-widget');
                                promotionDialog.querySelector(".dialog-buttons-message").innerHTML = widgetDescription;

                                if (promotionDialog.querySelector("a.storebuild-pro-dialog-button-action") === null) {

                                    let buttonElement = document.createElement("a"),
                                        buttonText = document.createTextNode( wp.i18n.__('Upgrade Now', 'storebuild') );

                                    buttonElement.classList.add(
                                        "dialog-button",
                                        "dialog-action",
                                        "dialog-buttons-action",
                                        "elementor-button",
                                        "storebuild-pro-dialog-button-action"
                                    );

                                    buttonElement.setAttribute("href", actionURL);
                                    buttonElement.setAttribute("target", "_blank");
                                    buttonElement.appendChild(buttonText);

                                    promotionDialog.querySelector(".dialog-buttons-action").insertAdjacentHTML("afterend", buttonElement.outerHTML);
                                    promotionDialog.querySelector(".storebuild-pro-dialog-button-action").style.backgroundColor = "#93003f";
                                    promotionDialog.querySelector(".storebuild-pro-dialog-button-action").style.textAlign = "center"; 
                                    promotionDialog.querySelector(".elementor-button.go-pro.dialog-buttons-action").classList.add('storebuild-elementor-pro-hide');

                                } else {
                                    promotionDialog.querySelector(".storebuild-pro-dialog-button-action").style.textAlign = "center"; 
                                    promotionDialog.querySelector(".elementor-button.go-pro.dialog-buttons-action").classList.add('storebuild-elementor-pro-hide');
                                }
                            } else {
                                promotionDialog?.classList.remove('storebuild-pro-widget');
                                if ( promotionDialog.querySelector(".storebuild-pro-dialog-button-action") !== null ) {
                                    promotionDialog.querySelector(".storebuild-pro-dialog-button-action").style.display = "none";
                                }
                            }
                            // Break The loop if target element has found
                            break;
                        }
                    }
                }


            });
        },

    };

    storebuildElementorEditorMode.init();
    
})( jQuery )