import { FC, createContext, useEffect, useState } from "react";
import { Service } from "../../api/service";
import { TGoods } from "../../type";
import style from "./goods.module.css";
import { WithBrandSelect } from "./selects/WithSelect/WithBrandSelect";
import { WithProductSelect } from "./selects/WithSelect/WithProductSelect";
import { WithPriceSelect } from "./selects/WithSelect/WithPriceSelect";
import Paginator from "./paginator/Paginator";
import { GoodsPage } from "./goods-page/GoodsPage";
import { FilterGoods } from "../filter/Filter";
//const GoodsContext = createContext({});
export type TTypeGoods = null | "goods" | "filtered_goods";
export const Goods = () => {
  const [currentPagination, setCurrentPagination] = useState<
    "filter" | "getAllGoods"
  >("getAllGoods");
  //
  const [typeGoods, setTypeGoods] = useState<TTypeGoods>(null);
  const [goods, setGoods] = useState<TGoods[]>([]);
  const [goodsIds, setGoodsIds] = useState<string[]>([]);
  const [filterIds, setFilterIds] = useState<string[]>([]);
  const [goodsInfo, setGoodsInfo] = useState<number>();
  const [isEndPagination, setIsEndpagination] = useState(true);

  //pagination
  const [currentOffset, setCurrentOffset] = useState(0);
  const [currentLimit, setCurrentLimit] = useState(10);
  /////
  const [loadingGoods, setLoadingGoods] = useState(false);
  ////

  const getGoods = (offset = currentOffset, limit = currentLimit) => {
    if (currentPagination === "filter") offset = 0;
    setLoadingGoods(true);
  };

  const handleClickLeft = () => {
    let offsetVar = currentOffset - currentLimit;
    if (currentPagination === "getAllGoods" || currentPagination === "filter") {
      if (currentOffset - currentLimit < 0) {
        offsetVar = 0;
        setCurrentOffset(0);
      } else {
        setCurrentOffset(offsetVar);
      }
      currentPagination === "getAllGoods" && getGoods(offsetVar);
    }
  };
  const onPageChange = async (page: number) => {
    if (goodsIds) {
      const listLimitedIds = goodsIds.slice(
        currentLimit * (page - 1),
        currentLimit * (page - 1) + currentLimit
      );
      const goods = await Service.getItems(listLimitedIds);
      setGoods(goods.result);
    }
  };
  const handleClickRight = () => {
    let offsetVar = currentOffset;
    if (!isEndPagination) {
      offsetVar = currentOffset + currentLimit;
      setCurrentOffset(offsetVar);
    }
    currentPagination === "getAllGoods" && getGoods(offsetVar);
  };
  return (
    <div>
      <GoodsPage
        onSetGoods={(goods) => setGoods(goods)}
        onSetGoodsIds={(ids) => setGoodsIds(ids)}
        listIds={goodsIds}
        typeGoods={typeGoods}
        onSetTypeGoods={(type) => setTypeGoods(type)}
      />
      <FilterGoods
        setGoods={(items) => setGoods(items)}
        setLoadingGoods={(isLoad) => setLoadingGoods(isLoad)}
        listIds={filterIds}
        onSetGoods={(goods) => setGoods(goods)}
        onSetGoodsIds={(ids) => setFilterIds(ids)}
        typeGoods={typeGoods}
        onSetTypeGoods={(type) => setTypeGoods(type)}
      />
      <h1>Просто получить список товаров без фильтра</h1>
      <button disabled={loadingGoods} onClick={() => getGoods()}>
        Get Goods
      </button>

      <h1>
        Ваши товары{" "}
        {`(offset = ${currentOffset}) isLoading = ${loadingGoods} // length = ${goodsInfo}`}
      </h1>
      {GetPaginatorByTypeGoods({
        filterIds,
        goodsIds,
        typeGoods,
        paginatorProps: { itemsPerPage: currentLimit, onPageChange },
      })}
      <div>
        <button
          disabled={goods.length === 0 || currentOffset <= 0 || loadingGoods}
          onClick={() => {
            handleClickLeft();
          }}
        >
          Click Left
        </button>
        <button
          disabled={loadingGoods || isEndPagination}
          onClick={() => handleClickRight()}
        >
          Click Right
        </button>
      </div>

      {GetComponentByTypeGoods({
        goods,
        typeGoods,
      })}
    </div>
  );
};

interface IListGoods {
  goods: TGoods[];
}
interface IGetComponentByTypeGoods {
  typeGoods: TTypeGoods;
  goods: TGoods[];
}
const GetComponentByTypeGoods = ({
  goods,
  typeGoods,
}: IGetComponentByTypeGoods) => {
  if (typeGoods === null) return null;
  if (!typeGoods === null && goods.length === 0)
    return <div>Упс, по вашему запросу ничего не найдено</div>;
  return <ListGoods goods={goods} />;
};
interface IGetPaginatorByTypeGoods {
  goodsIds: string[];
  filterIds: string[];
  typeGoods: TTypeGoods;
  paginatorProps: {
    itemsPerPage: number;
    onPageChange: (page: number) => void;
  };
}
const GetPaginatorByTypeGoods = ({
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
};
const ListGoods: FC<IListGoods> = ({ goods }) => {
  return (
    <>
      {goods.map((item) => (
        <article className={style.goods}>
          <h2>{item.product}</h2>
          <h2>{item.brand || "No Brand"}</h2>
          <h2>{item.price}</h2>
          <h2>{item.id}</h2>
        </article>
      ))}
    </>
  );
};
