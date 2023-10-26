import React from 'react';
import PropTypes from 'prop-types';
import './ShadowBox.scss';

const ShadowBox = ({ children }) => {
  return <div className="shadow-container">{children}</div>;
};

ShadowBox.propTypes = {};

export default ShadowBox;
