import { useState } from 'react';
import './Home.scss';
import Product from '../../components/Product';
import useFetch from '../../hooks/useFetch';
import productsApi from '../../api/products';
import { Link } from 'react-router-dom';

const Home = () => {
  const [selectedProducts, setSelectedProducts] = useState([]);

  const {
    data: products,
    isLoading,
    error,
    setData,
  } = useFetch({ url: '/products' });

  const isProductSelected = selectedProducts.length === 0;

  const handleDeleteProducts = async (e) => {
    try {
      if (isProductSelected) return;

      await productsApi.delete(selectedProducts);

      setData((prevData) =>
        prevData.filter((product) => !selectedProducts.includes(product.id))
      );
      setSelectedProducts([]);
    } catch (err) {
      console.error(err);
    }
  };

  const handleCheckboxes = (id, option = 'add') => {
    if (option === 'add') {
      setSelectedProducts([...selectedProducts, id]);
    }
    if (option === 'remove') {
      setSelectedProducts((prevProducts) =>
        prevProducts.filter((productId) => productId !== id)
      );
    }
  };

  if (isLoading) {
    return <p>Loading...</p>;
  }

  if (error) {
    return <p>Ops something went wrong</p>;
  }

  return (
    <>
      <main className="main">
        <div className="container">
          {!isLoading &&
            products?.map((product) => (
              <Product
                key={product.id}
                productData={product}
                handleCheckboxes={handleCheckboxes}
                selectedProducts={selectedProducts}
              />
            ))}
        </div>
      </main>

      <nav className="nav">
        <Link to={'/add-product'}>
          <button className="btn">ADD</button>
        </Link>
        <button
          id="delete-product-btn"
          className="btn"
          disabled={isProductSelected}
          onClick={handleDeleteProducts}
        >
          MASS DELETE
        </button>
      </nav>
    </>
  );
};

export default Home;
