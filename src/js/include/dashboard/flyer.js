(function($){

    var loading_in_process = false;

    function addAjaxInstruction(buttons, loading, number) {

        loading_in_process = true;
        loading.addClass('loading');

        let form_data = [];

        form_data.push({name: 'id', value: number});
        form_data.push({name: 'action', value: 'add_instruction'});

        $.ajax({
            type: 'post',
            url: sapc_CHECKER.ajaxurl,
            dataType: 'json',
            data: form_data,
            beforeSend: function () {
            },
            success: function (response) {
                buttons.before(response);

                init_instructions_inputs();
                init_remove_buttons();

                setTimeout(function(){
                    tinymce.execCommand( 'mceRemoveEditor', false, 'instruction' + number );
                    tinymce.execCommand( 'mceAddEditor', false, 'instruction' + number );
                }, 0)
            },
            error: function (response) {
                console.log(response);
            },
            complete: function () {
                loading_in_process = false;
                loading.removeClass('loading');
            }
        });
    }

    let set_flyer_instructions = function(){
        if(!$('#step-flyer').length) return;

        let instructions = [];
        $('#instruction-steps .instr-item').each(function(){
            let title = $(this).find('.item-wrapper .title input').val();
            let description = $(this).find('.item-wrapper .description textarea').val();
            instructions.push([title, description]);
        });

        let list = $('#flyer-steps ul');
        list.html('');

        instructions.forEach(function(item){
            list.append('' +
                '<li>' +
                '<b>' + item[0] + '</b>' +
                item[1] +
                '</li>');
        });
    }

    function init_instructions_inputs(){
        if(!$('#step-flyer').length) return;

        $('input[name^="instructions[title]"]').on('input change', function(){
            set_flyer_instructions();
        })
    }

    let set_flyer_ingredients = function(){
        if(!$('#step-flyer').length) return;

        let ingredients = [];
        let quantities = $('#ingredients_qty_wrapper').find("[id*='ingredients_qty']").find('input');
        $('#dish_ingredients ul li.select2-selection__choice').each(function(i){
            let title = $(this).attr('title');
            let image = $(this).find('img').attr('src');
            let quantity = quantities.eq(i).val();
            let url = quantities.eq(i).attr('product_url');
            ingredients.push([title, image, quantity, url]);
        });

        let list = $('#flyer-ingredients ul');
        list.html('');

        ingredients.forEach(function(item){
            list.append('' +
                '<li>' +
                '<a href="' + item[3] +'">' +
                '<img src="' + item[1] + '" alt=""/>' +
                '</a>' +
                '<span>' + item[2] + '</span>' +
                '<p><a href="' + item[3] +'">' + item[0] + '</a></p>' +
                '</li>');
        });
    }

    let set_flyer_tags = function(){
        if(!$('#step-flyer').length) return;

        let tags = [];

        //
        let list = $('#flyer-tags');
        //
        // tags.forEach(function(item){
        //     list.append('<span>' + '<a href="' + item[1] +'">' + item[0] + '</a>' + '</span>');
        // });
        let selected = $('#product_tags').find(':selected');
        if(selected.length === 0){
            list.html('');
            return;
        }

        list.html('<b>Tags: </b>');

        selected.each(function(i){
            list.append('<span>' + '<a href="' + __tags[$(this).val()][1] +'">' + $(this).text() + '</a>' + '</span>');
            if(i + 1 !== selected.length)
                list.append(', ');
        });
    }

    let set_flyer_information = function(){
        if(!$('#step-flyer').length) return;

        let container = $('#information');
        let name = container.find('#pro_title').val();
        let short_description = container.find('#excerpt').val();
        let image = container.find('#dish_featured_image').attr('src');

        let flyer_review_container = $('#flyer-review');
        flyer_review_container.find('.flyer-review .flyer-description .product-name h3').html(name);
        flyer_review_container.find('.flyer-review .flyer-description .product-description').html(short_description);
        flyer_review_container.find('.flyer-image img').attr('src', image);
    }

    let set_flyer_params = function(){
        if(!$('#step-flyer').length) return;

        let container = $('#information');
        let duration_select = container.find('select[name=dish_duration]');
        let duration = [
            [
                duration_select.val(),
                duration_select.find('option:selected').html(),
                duration_select.find('option:selected').attr('url')
            ]
        ];

        let difficulty_select = container.find('select[name=dish_difficulty]');
        let difficulty = [
            [
                difficulty_select.val(),
                difficulty_select.find('option:selected').html(),
                difficulty_select.find('option:selected').attr('url')
            ]
        ];

        let flyer_duration_container = $('#flyer-duration');
        flyer_duration_container.find('b').nextAll().remove();
        duration = duration.map(function(item){
            return '<span><a href="' + item[2] + '">' + item[1] + '</a></span>';
        });
        flyer_duration_container.find('b').after(duration.join(', '));

        let flyer_difficulty_container = $('#flyer-difficulty');
        flyer_difficulty_container.find('b').nextAll().remove();
        difficulty = difficulty.map(function(item){
            return '<span><a href="' + item[2] + '">' + item[1] + '</a></span>';
        });

        flyer_difficulty_container.find('b').after(difficulty.join(', '));
    }

    let set_flyer_category = function(category_select){
        if(!$('#step-flyer').length) return;

        let container = $('#information');

        let cat_name = category_select.find(':selected').text();
        let cat_value = category_select.val();
        let cat_url = __categories[category_select.val()][1];

        let category = [
            [
                cat_name,
                cat_value,
                cat_url
            ]
        ];


        let flyer_category_container = $('#flyer-categories');
        flyer_category_container.find('b').nextAll().remove();
        category = category.map(function(item){
            return '<span><a href="' + item[2] + '">' + item[0] + '</a></span>';
        });
        flyer_category_container.find('b').after(category.join(', '));
    }

    let init_remove_buttons = function(){
        $('.instr-remove').click(function(e){
            e.preventDefault();

            if (loading_in_process) return;

            let instr_item = $(this).closest('.instr-item');
            let id = instr_item.find('textarea.wp-editor-area').attr('id');

            tinymce.execCommand( 'mceRemoveEditor', false, id );
            instr_item.remove();

            set_flyer_instructions();
        })
    }

    jQuery(document).ready(function($){


        init_instructions_inputs();
        init_remove_buttons();

        $('.flyers-select a').click(function(e){
            e.preventDefault();
            let data = $(this).attr('data');
            let container = $(this).closest('.wcfm-container');
            $('.flyers-select a').removeClass('active');
            $(this).addClass('active');

            container.find('.inner.flyer').removeClass('active');
            $(data).addClass('active');
        });


        $('.instr-buttons .add-instruction').click(function(e){
            e.preventDefault();

            if (loading_in_process) return;

            let buttons = $('.instr-buttons');
            let count = $('#instruction-steps .instr-item').length;
            let id = count < 1 ? 0 : +($('#instruction-steps .instr-item').eq(count - 1).find('textarea.wp-editor-area').attr('id').replace('instruction', '')) + 1;
            console.log('id', id);
            let loading = $(this);

            addAjaxInstruction(buttons, loading, id);

        });


        if(typeof tinyMCE !== 'undefined'){

            // $('#instruction-steps .instr-item').each(function(){
            //     let textarea = $(this).find('textarea');
            //     console.log(textarea);
            //
            //     let editor = tinyMCE.get(textarea.attr('id'));
            //     editor.on('input init change', function (e) {
            //         let content = editor.getContent();
            //         $('textarea#' + editor.id).html(content);
            //
            //         set_flyer_instructions();
            //     });
            // });

            function getStats(id) {
                var body = tinymce.get(id).getBody(), text = tinymce.trim(body.innerText || body.textContent);

                return {
                    chars: text.length,
                    words: text.split(/[\w\u2019\'-]+/).length
                };
            }

            tinymce.on('AddEditor', function( event ) {
                let editor = event.editor;
                if(editor.id.indexOf('instruction') !== -1){
                    editor.on('input init change', function (e) {
                        var content = tinyMCE.activeEditor.getContent();
                        $('textarea#' + tinyMCE.activeEditor.id).html(content);

                        set_flyer_instructions();
                    });
                }
                if(editor.id === 'excerpt'){
                    editor.on('input change', function (e) {
                        let content = editor.contentDocument.body.innerText;
                        if(content.length > 300){
                            // content = content.substr(0, 300);
                            // editor.setContent(content, {format: 'raw'})
                            // $(editor.bodyElement).removeClass("mce-edit-focus")
                            // editor.selection.select(tinyMCE.activeEditor.getBody(), true);
                            // editor.selection.collapse(false);
                        }
                        $('textarea#' + editor.id).html(content);

                        //set_flyer_instructions();
                    });
                }



            }, true );
        }


        $('#dropdown_ingredients').on('select2:close', function(){
            setTimeout(function(){
                set_flyer_ingredients()
            }, 500);

        })

        $('#information select[name=dish_duration], #information select[name=dish_difficulty]').on('change', function(){
            set_flyer_params();
        })

        $('#information input').on('input change', function(){
            set_flyer_information();
        })

        $('#product_cats').on('select2:close', function(){
            set_flyer_category($(this));
        })

        $('#product_tags').on('select2:close', function(){
            set_flyer_tags();
        })

        setTimeout(function () {
            if((typeof tinyMCE !== 'undefined')&&(tinyMCE.EditorManager.get('excerpt'))){
                tinyMCE.EditorManager.get('excerpt').on('input init change', function (e) {
                    var content = this.getContent();
                    $('textarea#' + this.id).html(content);

                    set_flyer_information();
                });
            }


            // media_uploader.on("select", function(){
            //     console.log('media updated');
            //     set_flyer_information();
            // });
        }, 0);

        // let ingredients_ul = document.querySelector('#dish_ingredients ul');
        // ingredients_ul.addEventListener("DOMCharacterDataModified", function(){
        //     set_flyer_ingredients();
        //     console.log('ingr_updated');
        // }, false);


        set_flyer_params();
        set_flyer_category($('#product_cats'));
    });
})(jQuery)
