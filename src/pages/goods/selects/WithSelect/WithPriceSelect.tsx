import { FC } from "react";
import { SelectItem } from "../SelectItem";
import { useFilteredItems } from "../hooks/useFilteredItems";
import { IWithSelect } from "../interface";

export const WithPriceSelect: FC<IWithSelect> = ({ setSelect }) => {
  const { isLoading, items, getFilteredItems } = useFilteredItems("price");
  return (
    <SelectItem
      getInfo={getFilteredItems}
      items={items.map(String)}
      loadingSelect={isLoading}
      setSelectInfo={setSelect}
      title="Для того, чтобы получить информацию о доступных ценах"
      buttonTitle="Получить доступные цены"
    />
  );
};
