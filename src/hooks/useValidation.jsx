import { useState } from 'react';

const useValidation = () => {
  const [error, setError] = useState('');

  const validateForm = (fields, validationRules) => {
    let primaryError = '';

    Object.keys(validationRules).some((field) => {
      const { required, isNumber, custom, condition, errorMessage } =
        validationRules[field];

      if (condition && !condition(fields)) {
        return false;
      }

      if (required && !fields[field]) {
        primaryError = errorMessage || `${field} is required`;
        return true;
      }

      if (isNumber && isNaN(fields[field])) {
        primaryError = errorMessage || `${field} must be a number`;
        return true;
      }

      if (custom && !custom.validator(fields[field])) {
        primaryError = custom.errorMessage || `Invalid ${field}`;
        return true;
      }

      return false;
    });

    setError(primaryError);
    return primaryError === '';
  };
  //   Object.keys(validationRules).forEach((field) => {
  //     const { required, isNumber, customValidator, condition, errorMessage } =
  //       validationRules[field];

  //     if (condition && !condition(fields)) {
  //       return;
  //     }

  //     if (required && !fields[field]) {
  //       newErrors[field] = errorMessage || `${field} is required`;
  //     }

  //     if (isNumber && isNaN(fields[field])) {
  //       newErrors[field] = errorMessage || `${field} must be a number`;
  //     }

  //     if (customValidator && !customValidator(fields[field])) {
  //       newErrors[field] = errorMessage || `Invalid ${field}`;
  //     }
  //   });

  //   setErrors(newErrors);
  //   return Object.keys(newErrors).length === 0;
  // };

  return {
    error,
    setError,
    validateForm,
  };
};

export default useValidation;
