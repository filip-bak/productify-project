import React from 'react';
import PropTypes from 'prop-types';
import './Input.scss';

const Input = ({ id, label, row = true, ...props }) => {
  return (
    <label className="label">
      {label}
      <input className="input" id={id} name={id} type="text" {...props} />
    </label>
  );
};

Input.propTypes = {
  id: PropTypes.string,
  label: PropTypes.string,
};

export default Input;
