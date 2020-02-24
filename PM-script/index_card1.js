const card1 = document.getElementById('card1');

// to compute the center of the card retrieve its coordinates and dimensions
card1rect = card1.getBoundingClientRect();
const cx1 = card1rect.x + card1rect.width / 2;
const cy1 = card1rect.y + card1rect.height / 2;

// following the mousemove event compute the distance betwen the cursor and the center of the card
function handleMove1(e) {
  const { pageX, pageY } = e;

  // ! consider the relative distance in the [-1, 1] range
  const dx1 = (cx1 - pageX) / (card1rect.width / 2);
  const dy1 = (cy1 - pageY) / (card1rect.height / 2);

  // rotate the card around the x axis, according to the vertical distance, and around the y acis, according to the horizontal gap 
  this.style.transform = `rotateX(${10 * dy1 * -1}deg) rotateY(${10 * dx1}deg)`;
}

// following the mouseout event reset the transform property
function handleOut1() {
  this.style.transform = 'initial';
}

card1.addEventListener('mousemove', handleMove1);
card1.addEventListener('mouseout', handleOut1);