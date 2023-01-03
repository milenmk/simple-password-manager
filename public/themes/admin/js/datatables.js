$('#dataTable').DataTable( {
    language: {
        url: getLanguage()
    }
} );
function getLanguage() {
    var $langMap = {
        bg: 'bg',
        en: 'en-GB',
        fr: 'fr-FR'
    };
    var $lang = $('html').attr('lang').substr(0,2);
    return 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/' + $langMap[$lang] + '.json';
}