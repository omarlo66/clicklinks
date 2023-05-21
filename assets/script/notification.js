if($('.notice').length){
    $.get('/apis/notification.php?get=1', (data)=>{
        data = JSON.parse(data);
        count = data.length;
        if(count > 0){
            data.each((i, item)=>{
                notification('success', item, 10000);
                setTimeout(()=>{
                    $('.notification').remove();
                }, 10000);
                remove_notice(item);
                });
            }
        });
    }

function remove_notice(content){
    $.get('/apis/notification.php?remove=1&content='+content, (data)=>{
        console.log(data);
    });
}