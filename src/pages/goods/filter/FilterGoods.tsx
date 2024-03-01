import { FC } from "react";
import { WithBrandSelect } from "../selects/WithSelect/WithBrandSelect";
import { WithPriceSelect } from "../selects/WithSelect/WithPriceSelect";
import { WithProductSelect } from "../selects/WithSelect/WithProductSelect";
import { TGoods, TTypeGoods } from "../../../type";
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
  listIds,
  onSetGoods,
  onSetGoodsIds,
  onSetTypeGoods,
  typeGoods,
  setLoadingGoods
}) => {
  const {
    setBrandsSelect,
    setProductsSelect,
    setPricesSelect,
    isDisabledFilteredButton,
    handleRequest,
  } = useFilterGoods({
    listIds,
    onSetGoods,
    onSetGoodsIds,
    onSetTypeGoods,
    typeGoods,
    setLoadingGoods
  });

  return (
    <div>
      <WithBrandSelect setSelect={setBrandsSelect} />
      <WithProductSelect setSelect={setProductsSelect} />
      <WithPriceSelect setSelect={setPricesSelect} />
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
