import { FC, useState } from "react";
import { WithBrandSelect } from "../goods/selects/WithSelect/WithBrandSelect";
import { WithPriceSelect } from "../goods/selects/WithSelect/WithPriceSelect";
import { WithProductSelect } from "../goods/selects/WithSelect/WithProductSelect";
import { Service, TFilteredObj } from "../../api/service";
import { TGoods } from "../../type";
import { TTypeGoods } from "../goods/Googs";

interface IFilterGoods {
  setGoods: (items: any) => void;
  setLoadingGoods: (isLoad: boolean) => void;
  onSetGoods: (ids: TGoods[]) => void;
  onSetGoodsIds: (ids: string[]) => void;
  listIds: string[] | null;
  typeGoods: TTypeGoods;
  onSetTypeGoods: (type: TTypeGoods) => void;
}

export const FilterGoods: FC<IFilterGoods> = ({
  setGoods,
  setLoadingGoods,
  listIds,
  onSetGoods,
  onSetGoodsIds,
  onSetTypeGoods,
  typeGoods,
}) => {
  const [isFirstRequest, setIsFirstRequest] = useState(true);
  const [currentLimit, setCurrentLimit] = useState(40);
  const [currentOffset, setCurrentOffset] = useState(0);
  const [keyCacheState, setKeyCacheState] = useState("");

  const handleReqIsFirst = async () => {
    const filteredItems: TFilteredObj = {};
    let keyCache: string[] | string = [];
    if (pricesSelect !== "Ничего не выбрано") {
      filteredItems.price = +pricesSelect;
      keyCache.push(filteredItems.price.toString());
    }
    if (brandsSelect !== "Ничего не выбрано") {
      filteredItems.brand = brandsSelect;
      keyCache.push(filteredItems.brand);
    }
    if (productsSelect !== "Ничего не выбрано") {
      filteredItems.product = productsSelect;
      keyCache.push(filteredItems.product);
    }
    keyCache = keyCache.join("_");
    console.log(keyCacheState);

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
  const isDisabledFilteredButton = () =>
    pricesSelect === "Ничего не выбрано" &&
    brandsSelect === pricesSelect &&
    productsSelect === brandsSelect;

  const [pricesSelect, setPricesSelect] = useState<string>("Ничего не выбрано");
  const [brandsSelect, setBrandsSelect] = useState<string>("Ничего не выбрано");
  const [productsSelect, setProductsSelect] =
    useState<string>("Ничего не выбрано");
  ////
  return (
    <div>
      <WithBrandSelect select={brandsSelect} setSelect={setBrandsSelect} />
      <WithProductSelect
        select={productsSelect}
        setSelect={setProductsSelect}
      />
      <WithPriceSelect select={pricesSelect} setSelect={setPricesSelect} />
      <h1>
        Для того, чтобы сделать выборку по фильтру, выберите в селекте нужный
        элемент и нажмите кнопку ниже
      </h1>
      <button
        disabled={isDisabledFilteredButton()}
        onClick={() => handleReqIsFirst()}
      >
        Получить отфильтрованный список
      </button>
    </div>
  );
};
