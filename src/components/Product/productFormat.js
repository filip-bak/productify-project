export const furnitureFormat = (height, width, length) => {
  const furnitureDimensions = [
    parseFloat(height),
    parseFloat(width),
    parseFloat(length),
  ];

  return furnitureDimensions.join('x');
};
