<script>
  function filterCategory(category, btn) {
    // Filter the products
    const products = document.querySelectorAll('.product-card');
    products.forEach(product => {
      if (category === 'all' || product.dataset.category === category) {
        product.style.display = 'block';
      } else {
        product.style.display = 'none';
      }
    });

    // Set active class on clicked button
    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach(button => button.classList.remove('active'));
    btn.classList.add('active');
  }
</script>
