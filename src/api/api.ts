export const mainUrl = (url: string) =>
  `http://api.valantis.store:40000/${url}`;

// export type CustomPromise<T, F = any> = {
//   catch<TResult = never>(
//     onrejected?:
//       | ((reason: F) => TResult | PromiseLike<TResult>)
//       | undefined
//       | null
//   ): Promise<T | TResult>;
// } & Promise<T>;

export const fetchData = (
  url: string,
  method: string,
  data?: any,
  retries = 200,
  delay = 1000
) => {
  const headers = {
    "Content-Type": "application/json",
    "X-Auth": "d6d2e7f7df174fbd03e83b5abe40eeff",
  };

  const options: RequestInit = { method, headers };
  if (method === "POST" && data !== null) {
    options.body = JSON.stringify(data);
  }
  return fetch(url, options)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .catch((error) => {
      console.error("Error:", error);
      if (retries > 0) {
        console.log(`Retrying in ${delay} milliseconds...`);
        return new Promise((resolve) => {
          setTimeout(
            () => resolve(fetchData(url, method, data, retries - 1, delay)),
            delay
          );
        });
      } else {
        console.error("Error:", error);
      }
    });
};
