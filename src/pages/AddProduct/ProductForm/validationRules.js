const isInteger = (value) => {
  return Number.isInteger(Number(value));
};

export const validationRules = {
  sku: {
    required: true,
    errorMessage: 'SKU is required',
  },
  name: {
    required: true,
    errorMessage: 'Name is required',
  },
  price: {
    required: true,
    isNumber: true,
  },
  type: {
    required: true,
    errorMessage: 'Type is required',
  },
  size: {
    required: true,
    isNumber: true,
    custom: {
      validator: isInteger,
      errorMessage: 'Size must be an integer',
    },
    condition: (field) => field.type === 'DVD',
  },
  weight: {
    required: true,
    isNumber: true,
    condition: (field) => field.type === 'Book',
  },
  height: {
    required: true,
    isNumber: true,
    condition: (field) => field.type === 'Furniture',
  },
  width: {
    required: true,
    isNumber: true,
    condition: (field) => field.type === 'Furniture',
  },
  length: {
    required: true,
    isNumber: true,
    condition: (field) => field.type === 'Furniture',
  },
};
