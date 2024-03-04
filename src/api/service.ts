import { TypeFilter } from "../type";
import { fetchData, mainUrl } from "./api";

export type TFilteredSelect = "brand" | "product" | "price";
export type TFilteredObj = {
  brand?: string;
  product?: string;
  price?: number;
};

export const Service = {
  async getGoodsByActionFilter(filteredSelect: TFilteredObj) {
    const response = await fetchData(mainUrl(""), "POST", {
      action: "filter",
      params: { ...filteredSelect },
    });
    return response;
  },
  async getGoods() {
    const response = await fetchData(mainUrl(""), "POST", {
      action: "get_ids",
    });
    return response;
  },
  async getGoodsByField(field: TypeFilter) {
    const params: { [key: string]: number | string } = {
      field,
    };
    const response = await fetchData(mainUrl(""), "POST", {
      action: "get_fields",
      params,
    });
    const set = new Set<string | null>(response.result);
    set.delete(null);

    return Array.from(set.values()) as unknown as string[];
  },
  async getItems(data: string[]) {
    const response = await fetchData(mainUrl(""), "POST", {
      action: "get_items",
      params: { ids: data },
    });
    return response;
  },
};
