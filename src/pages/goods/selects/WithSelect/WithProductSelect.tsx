import { FC } from "react";
import { SelectItem } from "../SelectItem";
import { useFilteredItems } from "../hooks/useFilteredItems";
import { IWithSelect } from "../interface";

export const WithProductSelect: FC<IWithSelect> = ({ setSelect }) => {
  const { isLoading, items, getFilteredItems } = useFilteredItems("product");
  return (
    <SelectItem
      getInfo={getFilteredItems}
      items={items}
      loadingSelect={isLoading}
      setSelectInfo={setSelect}
      title="Для того, чтобы получить информацию о доступных названиях"
      buttonTitle="Получить доступные названия"
    />
  );
};
