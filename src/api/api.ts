import md5 from "md5";

export const mainUrl = (url: string) =>
  `https://api.valantis.store:41000/${url}`;

const addZeroInBeginDate = (number: number) => {
  if (number < 10) return `0${number}`;
};
export const fetchData = (
  url: string,
  method: string,
  data?: any,
  retries = 3,
  delay = 1000
) => {
  const date = new Date();
  const headers = {
    "Content-Type": "application/json",
    "X-Auth": md5(
      `${
        process.env.REACT_APP_SECRET_AUTH
      }_${date.getFullYear()}${addZeroInBeginDate(
        date.getMonth() + 1
      )}${addZeroInBeginDate(date.getDate())}`
    ),
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
