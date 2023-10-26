export const filterProductByType = (productData) => {
  const { sku, name, price, type, size, weight, height, width, length } =
    productData;

  const commonProductData = {
    sku,
    name,
    price,
    type,
  };

  const validProductTypes = {
    DVD: (commonProductData) => ({
      ...commonProductData,
      size,
    }),
    Book: (commonProductData) => ({ ...commonProductData, weight }),
    Furniture: (commonProductData) => ({
      ...commonProductData,
      height,
      width,
      length,
    }),
  };

  return validProductTypes[type](commonProductData);
};
