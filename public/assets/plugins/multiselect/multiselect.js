/*Select multiple category on FAQ*/
 jQuery(document).ready(function($) {
    $('#faq_category').multiselect({
        enableFiltering: true,
        filterPlaceholder: 'Type a Name',
        buttonWidth: '100%',
        nonSelectedText: 'Select an category!',
        maxHeight: 200
    });

 });