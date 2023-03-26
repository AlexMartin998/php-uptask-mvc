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

// mq
const checkMediaQuery = query => {
  const mediaQuery = window.matchMedia(query);
  // const isMatching = mediaQuery.matches;

  const handleChange = event => {
    const isMatching = event.matches;

    if (!isMatching) sidebar.classList.remove('show');
  };

  mediaQuery.addEventListener('change', handleChange);

  // return isMatching;
};

checkMediaQuery('(max-width: 600px)');
