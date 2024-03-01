import Paginator from "../paginator/Paginator";
import { IGetPaginatorByTypeGoods } from "./interface";

export const GetPaginatorByTypeGoods = ({
  goodsIds,
  filterIds,
  typeGoods,
  paginatorProps,
}: IGetPaginatorByTypeGoods) => {
  if (typeGoods === null || (goodsIds.length === 0 && filterIds.length === 0))
    return null;
  if (typeGoods === "goods")
    return <Paginator totalItems={goodsIds.length} {...paginatorProps} />;
  if (typeGoods === "filtered_goods")
    return <Paginator totalItems={filterIds.length} {...paginatorProps} />;
  return null;
};
