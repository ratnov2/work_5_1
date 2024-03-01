import { createContext, useContext, useState } from "react";
import { Service } from "../../api/service";
import { TGoods, TTypeGoods } from "../../type";
import { GoodsPage } from "./goods-info/GoodsInfo";
import { FilterGoods } from "./filter/FilterGoods";
import { PageInfoContext } from "../../contexts/PageInfoContext";
import { GetPaginatorByTypeGoods } from "./paginator-render/PaginatorRender";
import { GetComponentByTypeGoods } from "./goods-render/GoodsRender";
export const GoodsContextPageInfo = createContext({});

export const Goods = () => {
  const { limit, offset } = useContext(PageInfoContext);

  const [typeGoods, setTypeGoods] = useState<TTypeGoods>(null);
  const [goods, setGoods] = useState<TGoods[]>([]);
  const [goodsIds, setGoodsIds] = useState<string[]>([]);
  const [filterIds, setFilterIds] = useState<string[]>([]);
  
  /////
  const [loadingGoods, setLoadingGoods] = useState(false);
  ////

  const onPageChange = async (page: number) => {
    setLoadingGoods(true);
    let listLimitedIds: string[] = [];
    if (typeGoods === "goods") {
      listLimitedIds = goodsIds.slice(
        limit * (page - 1),
        limit * (page - 1) + limit
      );
    } else if (typeGoods === "filtered_goods") {
      listLimitedIds = filterIds.slice(
        limit * (page - 1),
        limit * (page - 1) + limit
      );
    }
    const goods = await Service.getItems(listLimitedIds);
    setGoods(goods.result);
    setLoadingGoods(false);
  };

  return (
    <GoodsContextPageInfo.Provider value={{}}>
      <FilterGoods
        setLoadingGoods={(isLoad) => setLoadingGoods(isLoad)}
        listIds={filterIds}
        onSetGoods={(goods) => setGoods(goods)}
        onSetGoodsIds={(ids) => setFilterIds(ids)}
        typeGoods={typeGoods}
        onSetTypeGoods={(type) => setTypeGoods(type)}
      />
      <h1>Просто получить список товаров без фильтра</h1>
      <GoodsPage
        setLoadingGoods={(isLoad) => setLoadingGoods(isLoad)}
        onSetGoods={(goods) => setGoods(goods)}
        onSetGoodsIds={(ids) => setGoodsIds(ids)}
        listIds={goodsIds}
        typeGoods={typeGoods}
        onSetTypeGoods={(type) => setTypeGoods(type)}
      />
      <h1>
        Ваши товары{" "}
        {`ItemsOnPage = ${limit} isLoading = ${loadingGoods} // length = ${
          typeGoods === "filtered_goods"
            ? filterIds.length
            : typeGoods === "goods"
            ? goodsIds.length
            : null
        }`}
      </h1>
      <GetPaginatorByTypeGoods
        filterIds={filterIds}
        goodsIds={goodsIds}
        typeGoods={typeGoods}
        paginatorProps={{ itemsPerPage: limit, onPageChange }}
      />
      <GetComponentByTypeGoods goods={goods} typeGoods={typeGoods} />
    </GoodsContextPageInfo.Provider>
  );
};
