import React from 'react';
import PropTypes from 'prop-types';
import Button from '../Button';
import { Link } from 'react-router-dom';

const AddProductHeader = ({ handleSaveProduct }) => {
  return (
    <>
      <h1>Product Add</h1>
      <button onClick={handleSaveProduct} type="submit">
        Save
      </button>
      <Button onClick={handleSaveProduct}></Button>
      <Link to="/">
        <Button>Cancel</Button>
      </Link>
    </>
  );
};

AddProductHeader.propTypes = {};

export default AddProductHeader;
