import React, { useState } from 'react';
import PropTypes from 'prop-types';
import Input from '../../../components/Input';
import Select from '../../../components/Select';
import productsApi from '../../../api/products';
import './ProductForm.scss';
import { filterProductByType } from './productValidation';
import Description from '../../../components/Description';
import { useNavigate } from 'react-router-dom';
import useValidation from '../../../hooks/useValidation';
import { validationRules } from './validationRules';
import ShadowBox from '../../../components/Shadow';
import Error from '../../../components/Error';

const initialState = {
  sku: '',
  name: '',
  price: '',
  type: '',
  weight: '',
  size: '',
  height: '',
  width: '',
  length: '',
};

const ProductForm = () => {
  const [product, setProduct] = useState(initialState);
  const { error, setError, validateForm } = useValidation();

  const navigate = useNavigate();

  const handleSaveProduct = async (e) => {
    try {
      e.preventDefault();

      if (!validateForm(product, validationRules)) return;

      const newProducts = filterProductByType(product);
      await productsApi.add(newProducts);

      navigate('/');
    } catch (err) {
      console.error(err);
      if (err?.status === 409) {
        setError('SKU already exists. Please provide a unique SKU.');
        return;
      } else {
        setError('An error occurred while saving the product.');
      }
    }
  };

  const handleChange = (e) => {
    const { id, value } = e.target;

    console.log('targetValue', value);

    setProduct((prevProduct) => ({
      ...prevProduct,
      [id]: value,
    }));
  };

  const handleSelectChange = (e) => {
    const { name, value } = e.target;

    setProduct((prevProduct) => ({
      ...prevProduct,
      [name]: value,
    }));
  };

  console.log('PRODUCT', product);

  return (
    <>
      <form
        id="product_form"
        className="product-form"
        onSubmit={handleSaveProduct}
      >
        <Input id={'sku'} label={'SKU'} onChange={handleChange} />
        <Input id={'name'} label={'Name'} onChange={handleChange} />
        <Input id={'price'} label={'Price ($)'} onChange={handleChange} />
        <Select
          name="type"
          id={'productType'}
          label={'Type Switcher'}
          placeholder={'Select'}
          options={['DVD', 'Book', 'Furniture']}
          onChange={handleSelectChange}
        />
        {product.type === 'Book' && (
          <>
            <Input
              id={'weight'}
              label={'Weight (KG)'}
              onChange={handleChange}
            />
            <Description>Please provide weight in kilograms</Description>
          </>
        )}

        {product.type === 'DVD' && (
          <>
            <Input id={'size'} label={'Size (MB)'} onChange={handleChange} />
            <Description>Please provide size in megabytes</Description>
          </>
        )}

        {product.type === 'Furniture' && (
          <>
            <Input
              id={'height'}
              label={'Height (CM)'}
              onChange={handleChange}
            />
            <Input id={'width'} label={'Width (CM)'} onChange={handleChange} />
            <Input
              id={'length'}
              label={'Length (CM)'}
              onChange={handleChange}
            />
            <Description>Please provide dimensions in HxWxL format</Description>
          </>
        )}
      </form>
      {error && (
        <ShadowBox>
          <Error message={error} />
        </ShadowBox>
      )}
    </>
  );
};

ProductForm.propTypes = {};

export default ProductForm;
