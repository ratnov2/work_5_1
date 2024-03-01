export type TGoods = {
  brand: null | string;
  id: string;
  price: number;
  product: string;
};
export type TypeFilter = "product" | "brand" | "price";

export type TTypeGoods = null | "goods" | "filtered_goods";
