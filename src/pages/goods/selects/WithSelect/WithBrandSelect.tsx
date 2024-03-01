import { FC } from "react";
import { SelectItem } from "../SelectItem";
import { IWithSelect } from "../interface";
import { useFilteredItems } from "../hooks/useFilteredItems";

export const WithBrandSelect: FC<IWithSelect> = ({ setSelect }) => {
  const { isLoading, items, getFilteredItems } =
    useFilteredItems("brand");
  return (
    <SelectItem
      getInfo={getFilteredItems}
      items={items}
      loadingSelect={isLoading}
      setSelectInfo={setSelect}
      title="Для того, чтобы получить информацию о доступных брендах"
      buttonTitle="Получить доступные бренды"
    />
  );
};
