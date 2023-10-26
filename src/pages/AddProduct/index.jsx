import productsApi from '../../api/products';
import { Link } from 'react-router-dom';
import ProductForm from './ProductForm';

const AddProduct = (props) => {
  return (
    <>
      <main className="main">
        <ProductForm />
      </main>
      <nav className="nav">
        <button className="btn" form="product_form" type="submit">
          Save
        </button>
        <Link to={'/'}>
          <button className="btn">Cancel</button>
        </Link>
      </nav>
    </>
  );
};

export default AddProduct;
