

let element = '.textarea'
if($(element).length){
    init_textarea();
}
function toolbar(){
    html = '<div class="toolbar">'+
                '<button class="bold_btn"><i class="fa fa-bold" aria-hidden="true"></i></button>'+
                '<button class="italic_btn"><i class="fa fa-italic" aria-hidden="true"></i></button>'+
                '<button class="underline_btn"><i class="fa fa-underline" aria-hidden="true"></i></button>'+
                '<button class="upload"><i class="fa fa-image" aria-hidden="true"></i></button>'+
                '<button class="link"><i class="fa fa-link" aria-hidden="true"></i></button>'+
                '<button class="h2"><p>h2</p></button>'+
            '</div>';
    return html;
}

function init_Textarea(){

    $('#textarea_1').append(toolbar());
    $('.bold_btn').click( () => {
        const text = textarea.value;
        const selectionStart = textarea.selectionStart;
        const selectionEnd = textarea.selectionEnd;
        const selectedText = text.substring(selectionStart, selectionEnd);
        const newText = text.substring(0, selectionStart) + '<b>' + selectedText + '</b>' + text.substring(selectionEnd);
        textarea.value = newText;
    });

    $('.italic_btn').click( () => {
        const text = textarea.value;
        const selectionStart = textarea.selectionStart;
        const selectionEnd = textarea.selectionEnd;
        const selectedText = text.substring(selectionStart, selectionEnd);
        const newText = text.substring(0, selectionStart) + '<i>' + selectedText + '</i>' + text.substring(selectionEnd);
        textarea.value = newText;
    });

    $('.underline_btn').addEventListener('click', () => {
        const text = textarea.value;
        const selectionStart = textarea.selectionStart;
        const selectionEnd = textarea.selectionEnd;
        const selectedText = text.substring(selectionStart, selectionEnd);
        const newText =text.substring(0, selectionStart) + '<u>' + selectedText + '</u>' + text.substring(selectionEnd);
        textarea.value = newText;
    });
    $('.h2').click( () => {
        const text = textarea.value;
        const selectionStart = textarea.selectionStart;
        const selectionEnd = textarea.selectionEnd;
        const selectedText = text.substring(selectionStart, selectionEnd);
        const newText = text.substring(0, selectionStart) + '<h2>' + selectedText + '</h2>' + text.substring(selectionEnd);
        textarea.value = newText;
    }
    );
    $('.link').click( () => {
        const text = textarea.value;
        const selectionStart = textarea.selectionStart;
        const selectionEnd = textarea.selectionEnd;
        const selectedText = text.substring(selectionStart, selectionEnd);
        let link = popup('link',selectedText);
        const newText = text.substring(0, selectionStart) + '<a href="'+link+'">' + selectedText + '</a>' + text.substring(selectionEnd);
        textarea.value = newText;
    });
}

function popup(type,selectedText){
    if(type == 'link'){
        link = '#';
        let textarea = $('#textarea').html();
        let popup = '<div class="popup">'+
                        '<div class="popup-content">'+
                            '<p>your link: </p> <input type="text" id="link" value="https://">'+
                            '<button class="submit">submit</button>'+
                        '</div>'+
                    '</div>';
        $('#textarea').append(popup+textarea);
        $('.submit').click(()=>{
            let link = $('#link').val();
            $('.popup').remove();
            return link;
        });
        return link;
    }
}