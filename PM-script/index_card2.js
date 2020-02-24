const card2 = document.getElementById('card2');

// to compute the center of the card retrieve its coordinates and dimensions
card2rect = card2.getBoundingClientRect();
const cx2 = card2rect.x + card2rect.width / 2;
const cy2 = card2rect.y + card2rect.height / 2;

// following the mousemove event compute the distance betwen the cursor and the center of the card
function handleMove2(e) {
  const { pageX, pageY } = e;

  // ! consider the relative distance in the [-1, 1] range
  const dx2 = (cx2 - pageX) / (card2rect.width / 2);
  const dy2 = (cy2 - pageY) / (card2rect.height / 2);

  // rotate the card around the x axis, according to the vertical distance, and around the y acis, according to the horizontal gap 
  this.style.transform = `rotateX(${10 * dy2 * -1}deg) rotateY(${10 * dx2}deg)`;
}

// following the mouseout event reset the transform property
function handleOut2() {
  this.style.transform = 'initial';
}

card2.addEventListener('mousemove', handleMove2);
card2.addEventListener('mouseout', handleOut2);