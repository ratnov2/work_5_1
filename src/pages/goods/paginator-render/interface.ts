import { TTypeGoods } from "../../../type";

export interface IGetPaginatorByTypeGoods {
  goodsIds: string[];
  filterIds: string[];
  typeGoods: TTypeGoods;
  paginatorProps: {
    itemsPerPage: number;
    onPageChange: (page: number) => Promise<void>;
  };
}
