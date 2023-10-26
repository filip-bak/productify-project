import axios from 'axios';
import { ProductAddError } from '../shared/errors';

axios.defaults.baseURL =
  'https://productify-project.000webhostapp.com/api/index.php';

export const productsApi = {
  add: async (product) => {
    try {
      const { data } = await axios.post('/products', JSON.stringify(product));
      return data;
    } catch (err) {
      console.error(err);
      throw new ProductAddError('Failed to add product', err.request.status);
    }
  },

  delete: async (productIds) => {
    try {
      const { data } = await axios.post('/products/delete', {
        productIds,
      });
      console.log(data);
      return data;
    } catch (err) {
      console.error(err);
    }
  },
};

export default productsApi;
