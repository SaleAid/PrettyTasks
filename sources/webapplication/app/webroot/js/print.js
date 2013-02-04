function initPrintClick(element){
    $(element).on('click', function(){
        window.print();
        return false;
    });
}
