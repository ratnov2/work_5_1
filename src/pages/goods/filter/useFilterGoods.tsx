import { FC, useContext, useState } from "react";
import { Service, TFilteredObj } from "../../../api/service";
import { PageInfoContext } from "../../../contexts/PageInfoContext";
import { TGoods, TTypeGoods } from "../../../type";

interface IUseFilterGoods {
  onSetGoodsIds: (items: string[]) => void;
  onSetGoods: (goods: TGoods[]) => void;
  listIds: string[] | null;
  typeGoods: TTypeGoods;
  onSetTypeGoods: (type: TTypeGoods) => void;
  setLoadingGoods: (isLoad: boolean) => void;
}

export const useFilterGoods = ({
  listIds,
  onSetGoods,
  onSetGoodsIds,
  typeGoods,
  onSetTypeGoods,
}: IUseFilterGoods) => {
  const { limit, offset } = useContext(PageInfoContext);
  const [isFirstRequest, setIsFirstRequest] = useState(true);
  const [keyCacheState, setKeyCacheState] = useState("");
  const [pricesSelect, setPricesSelect] = useState<string>("");
  const [brandsSelect, setBrandsSelect] = useState<string>("");
  const [productsSelect, setProductsSelect] = useState<string>("");

  const [loading, setLoading] = useState(false);

  const handleRequest = async () => {
    const filteredItems: TFilteredObj = {};
    let keyCache: string[] | string = [];
    if (pricesSelect !== "") {
      filteredItems.price = +pricesSelect;
      keyCache.push(filteredItems.price.toString());
    }
    if (brandsSelect !== "") {
      filteredItems.brand = brandsSelect;
      keyCache.push(filteredItems.brand);
    }
    if (productsSelect !== "") {
      filteredItems.product = productsSelect;
      keyCache.push(filteredItems.product);
    }
    setLoading(true);
    keyCache = keyCache.join("_");
    let listLimitedIds = [];
    if (keyCache !== keyCacheState) setKeyCacheState(keyCache);
    if (isFirstRequest || keyCache !== keyCacheState) {
      const listIds = await Service.getGoodsByActionFilter(filteredItems);
      onSetGoodsIds(listIds.result);
      listLimitedIds = listIds.result.slice(offset, offset + limit);
      setIsFirstRequest(false);
    } else {
      listLimitedIds = listIds ? listIds.slice(offset, offset + limit) : [];
    }
    const goods = await Service.getItems(listLimitedIds);
    onSetGoods(goods.result);
    typeGoods !== "filtered_goods" && onSetTypeGoods("filtered_goods");
    setLoading(false);
  };
  const isDisabledFilteredButton =
    (pricesSelect === "" &&
      brandsSelect === pricesSelect &&
      productsSelect === brandsSelect) ||
    loading;
  return {
    brandsSelect,
    setBrandsSelect,
    productsSelect,
    setProductsSelect,
    pricesSelect,
    setPricesSelect,
    isDisabledFilteredButton,
    handleRequest,
  };
};
