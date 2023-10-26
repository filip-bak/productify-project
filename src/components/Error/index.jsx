import React from 'react';
import PropTypes from 'prop-types';
import './Error.scss';

const Error = ({ message }) => {
  return <p className="error">{message}</p>;
};

Error.propTypes = {};

export default Error;
