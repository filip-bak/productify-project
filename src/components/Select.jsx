import React from 'react';
import PropTypes from 'prop-types';

const Select = ({ id, name, label, placeholder, options = [], ...props }) => {
  return (
    <label className="label">
      {label}
      <select className="input" name={name || id} id={id} {...props}>
        <option hidden value="">
          {placeholder}
        </option>
        {options.map((option) => {
          const value = option.toLowerCase();
          return (
            <option key={value} id={value} value={option}>
              {option}
            </option>
          );
        })}
      </select>
    </label>
  );
};

Select.propTypes = {
  id: PropTypes.string,
  label: PropTypes.string,
  options: PropTypes.arrayOf(PropTypes.string),
};

export default Select;
