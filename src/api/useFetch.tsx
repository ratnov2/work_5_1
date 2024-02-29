import { useState, useEffect } from "react";

function useFetch(req: () => Promise<any>) {
  const [data, setData] = useState(null);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    setLoading(true);
    req()
      .then((res) => setData(res))
      .catch((err) => setError(err))
      .finally(() => setLoading(false));
  },[]);

  return { data, error, loading };
}

export default useFetch;
