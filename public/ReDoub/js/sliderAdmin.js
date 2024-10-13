document.addEventListener("DOMContentLoaded", function() {
    var readMoreLinks = document.querySelectorAll('.read-more');
    
    readMoreLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            var contentWrapper = this.parentNode.parentNode;
            var fullContent = contentWrapper.querySelector('.full-content');
            var contentProduct = contentWrapper.querySelector('.contentproduct');
            
            contentProduct.style.display = 'none';
            fullContent.style.display = 'block';
        });
    });
});
