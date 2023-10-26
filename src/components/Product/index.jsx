import PropTypes from 'prop-types';
import './Product.scss';
import { furnitureFormat } from './productFormat';

const Product = ({ productData, selectedProducts, handleCheckboxes }) => {
  if (!productData) return;

  const { id, sku, name, price, type } = productData;

  const isBook = type === 'Book';
  const isDVD = type === 'DVD';
  const isFurniture = type === 'Furniture';

  const handleCheckbox = (e) => {
    const { checked, value } = e.target;
    const id = parseInt(value);

    if (checked) {
      handleCheckboxes(id);
    } else {
      handleCheckboxes(id, 'remove');
    }
  };

  return (
    <div className="product">
      <input
        className="delete-checkbox"
        type="checkbox"
        value={id}
        checked={selectedProducts.includes(id)}
        onChange={handleCheckbox}
      />
      <ul className="product__list">
        <li>{sku}</li>
        <li>{name}</li>
        <li>{price} $</li>
        {isBook && <li>Weight: {Math.floor(productData.weight)}KG</li>}
        {isDVD && <li>Size: {productData.size} MB</li>}
        {isFurniture && (
          <li>
            Dimensions:&nbsp;
            {furnitureFormat(
              productData.height,
              productData.width,
              productData.length
            )}
          </li>
        )}
      </ul>
    </div>
  );
};

Product.propTypes = {};

export default Product;
