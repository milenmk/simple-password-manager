function copyToClipboard(val, event) {
    var inp = document.createElement('input');
    document.body.appendChild(inp)
    inp.value = val;
    inp.select();
    document.execCommand('copy', false);
    inp.remove();
    //alert('copied');
}