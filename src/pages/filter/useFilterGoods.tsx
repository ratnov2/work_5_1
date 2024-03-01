import { FC, useContext, useState } from "react";
import { Service, TFilteredObj } from "../../api/service";
import { PageInfoContext } from "../../contexts/PageInfoContext";
import { TGoods } from "../../type";
import { TTypeGoods } from "../goods/Googs";

interface IUseFilterGoods {
  onSetGoodsIds: (items: string[]) => void;
  onSetGoods: (goods: TGoods[]) => void;
  listIds: string[] | null;
  typeGoods: TTypeGoods;
  onSetTypeGoods: (type: TTypeGoods) => void;
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

  const [currentLimit, setCurrentLimit] = useState(limit);
  const [currentOffset, setCurrentOffset] = useState(offset);
  const [keyCacheState, setKeyCacheState] = useState("");

  const [pricesSelect, setPricesSelect] = useState<string>("");
  const [brandsSelect, setBrandsSelect] = useState<string>("");
  const [productsSelect, setProductsSelect] = useState<string>("");

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
    keyCache = keyCache.join("_");

    if (keyCache !== keyCacheState) setKeyCacheState(keyCache);
    if (isFirstRequest || keyCache !== keyCacheState) {
      const listIds = await Service.getGoodsByActionFilter(filteredItems);
      onSetGoodsIds(listIds.result);
      const listLimitedIds = listIds.result.slice(
        currentOffset,
        currentOffset + currentLimit
      );
      setIsFirstRequest(false);
      const goods = await Service.getItems(listLimitedIds);
      onSetGoods(goods.result);
    } else {
      const listLimitedIds = listIds
        ? listIds.slice(currentOffset, currentOffset + currentLimit)
        : [];
      const goods = await Service.getItems(listLimitedIds);
      onSetGoods(goods.result);
    }
    typeGoods !== "filtered_goods" && onSetTypeGoods("filtered_goods");
  };
  const isDisabledFilteredButton =
    pricesSelect === "" &&
    brandsSelect === pricesSelect &&
    productsSelect === brandsSelect;
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
