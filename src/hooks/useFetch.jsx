import { useEffect, useState } from 'react';
import axios from 'axios';

axios.defaults.baseURL =
  'https://productify-project.000webhostapp.com/api/index.php';

const useFetch = ({ url }) => {
  const [data, setData] = useState(null);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    setIsLoading(true);

    const controller = new AbortController();
    const fetchData = async () => {
      try {
        const response = await axios.get(url, {
          signal: controller.signal,
        });
        setData(response.data);
      } catch (err) {
        console.error(err);
        setError(err);
        setData(null);
      } finally {
        setIsLoading(false);
      }
    };

    fetchData();

    return () => {
      controller?.abort();
    };
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [url]);

  return { data, error, setData, isLoading };
};

export default useFetch;
