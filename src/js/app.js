const mobileMenuBtn = document.querySelector('.menu');
const closeMenuBtn = document.querySelector('#close-menu');
const sidebar = document.querySelector('.sidebar');

if (mobileMenuBtn)
  mobileMenuBtn.addEventListener('click', function () {
    sidebar.classList.add('show');
  });

if (closeMenuBtn)
  closeMenuBtn.addEventListener('click', function () {
    sidebar.classList.add('hidden');
    setTimeout(() => {
      sidebar.classList.remove('show');
      sidebar.classList.remove('hidden');
    }, 300);
  });
