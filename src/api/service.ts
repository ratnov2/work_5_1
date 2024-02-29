import { TypeFilter } from "../type";
import { fetchData, mainUrl } from "./api";

export type TFilteredSelect = "brand" | "product" | "price";
export type TFilteredObj = {
  brand?: string;
  product?: string;
  price?: number;
};

export const Service = {
  async getGoodsByActionFilter(
    filteredSelect: TFilteredObj
    // offset = 0,
    // limit = 50
  ) {
    const response = await fetchData(mainUrl(""), "POST", {
      action: "filter",
      params: { ...filteredSelect },
    });
    return response;
    // const addResponse: {
    //   isEndPagination: boolean;
    //   result?: string[];
    //   itemLength: number;
    // } = {
    //   isEndPagination: false,
    //   itemLength: response.result.length,
    // };
    // if (response.result.length <= 0) addResponse.isEndPagination = true;
    // for (let i = 0; i < response.result.length && set.size < limit; i++) {
    //   set.add(response.result[i]);
    // }

    // const items = await getItems(Array.from(set.values()) as string[]);
    // const res = {
    //   items: items.result,
    //   ...addResponse,
    // };
    // return res;
  },
  async getGoods() {
    const set = new Set();
    const response = await fetchData(mainUrl(""), "POST", {
      action: "get_ids",
      // params: { offset, limit },
    });

    // const addResponse: { isEndPagination: boolean; result?: string[] } = {
    //   isEndPagination: false,
    // };
    // if (response.result.length <= 0) addResponse.isEndPagination = true;

    // response.result.map((item: string) => set.add(item));

    // const items = await getItems(Array.from(set.values()) as string[]);
    // const res = {
    //   offset,
    //   limit,
    //   items: items.result,
    // };
    //return res;
    return response;
  },
  async getGoodsByField(field: TypeFilter, offset = 0, limit = 30) {
    const params: { [key: string]: number | string } = {
      field,
      // offset,
      // limit,
    };
    const response = await fetchData(mainUrl(""), "POST", {
      action: "get_fields",
      params,
    });
    const addResponse: { isEndPagination: boolean; result?: string[] } = {
      isEndPagination: false,
    };
    if (response.result.length <= 0) addResponse.isEndPagination = true;

    addResponse.result = response.result.filter(
      (element: string | null) => !!element
    );

    return addResponse;
  },
  async getItems(data: string[]) {
    const response = await fetchData(mainUrl(""), "POST", {
      action: "get_items",
      params: { ids: data },
    });
    return response;
  },
};

async function getItems(data: string[]) {
  const response = await fetchData(mainUrl(""), "POST", {
    action: "get_items",
    params: { ids: data },
  });
  return response;
}
