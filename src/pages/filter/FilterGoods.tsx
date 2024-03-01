import { FC, useContext, useState } from "react";
import { WithBrandSelect } from "../goods/selects/WithSelect/WithBrandSelect";
import { WithPriceSelect } from "../goods/selects/WithSelect/WithPriceSelect";
import { WithProductSelect } from "../goods/selects/WithSelect/WithProductSelect";
import { Service, TFilteredObj } from "../../api/service";
import { TGoods } from "../../type";
import { TTypeGoods } from "../goods/Googs";
import { PageInfoContext } from "../../contexts/PageInfoContext";
import { useFilterGoods } from "./useFilterGoods";

interface IFilterGoods {
  setLoadingGoods: (isLoad: boolean) => void;
  onSetGoods: (ids: TGoods[]) => void;
  onSetGoodsIds: (ids: string[]) => void;
  listIds: string[] | null;
  typeGoods: TTypeGoods;
  onSetTypeGoods: (type: TTypeGoods) => void;
}

export const FilterGoods: FC<IFilterGoods> = ({
  setLoadingGoods,
  listIds,
  onSetGoods,
  onSetGoodsIds,
  onSetTypeGoods,
  typeGoods,
}) => {
  const {
    brandsSelect,
    setBrandsSelect,
    productsSelect,
    setProductsSelect,
    pricesSelect,
    setPricesSelect,
    isDisabledFilteredButton,
    handleRequest,
  } = useFilterGoods({
    listIds,
    onSetGoods,
    onSetGoodsIds,
    onSetTypeGoods,
    typeGoods,
  });
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
        disabled={isDisabledFilteredButton}
        onClick={() => handleRequest()}
      >
        Получить отфильтрованный список
      </button>
    </div>
  );
};
