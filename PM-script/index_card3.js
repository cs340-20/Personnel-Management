const card3 = document.getElementById('card3');

// to compute the center of the card retrieve its coordinates and dimensions
card3rect = card3.getBoundingClientRect();
const cx3 = card3rect.x + card3rect.width / 2;
const cy3 = card3rect.y + card3rect.height / 2;

// following the mousemove event compute the distance betwen the cursor and the center of the card
function handleMove3(e) {
  const { pageX, pageY } = e;

  // ! consider the relative distance in the [-1, 1] range
  const dx3 = (cx3 - pageX) / (card3rect.width / 2);
  const dy3 = (cy3 - pageY) / (card3rect.height / 2);

  // rotate the card around the x axis, according to the vertical distance, and around the y acis, according to the horizontal gap 
  this.style.transform = `rotateX(${10 * dy3 * -1}deg) rotateY(${10 * dx3}deg)`;
}

// following the mouseout event reset the transform property
function handleOut3() {
  this.style.transform = 'initial';
}

card3.addEventListener('mousemove', handleMove3);
card3.addEventListener('mouseout', handleOut3);