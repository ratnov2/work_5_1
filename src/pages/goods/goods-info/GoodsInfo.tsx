import { FC, useContext, useState } from "react";
import { Service } from "../../../api/service";
import { TGoods, TTypeGoods } from "../../../type";
import { PageInfoContext } from "../../../contexts/PageInfoContext";

interface IGoodsPage {
  onSetGoods: (ids: TGoods[]) => void;
  setLoadingGoods: (isLoad: boolean) => void;
  onSetGoodsIds: (ids: string[]) => void;
  listIds: string[] | null;
  typeGoods: TTypeGoods;
  onSetTypeGoods: (type: TTypeGoods) => void;
}

export const GoodsPage: FC<IGoodsPage> = ({
  onSetGoods,
  onSetGoodsIds,
  listIds,
  onSetTypeGoods,
  typeGoods,
  setLoadingGoods,
}) => {
  const { limit, offset } = useContext(PageInfoContext);
  const [isFirstRequest, setIsFirstRequest] = useState(true);
  const handleReqIsFirst = async () => {
    setLoadingGoods(true);
    let listLimitedIds = [];
    if (isFirstRequest) {
      const listIds = await Service.getGoods();
      onSetGoodsIds(listIds.result);
      listLimitedIds = listIds.result.slice(offset, offset + limit);
      setIsFirstRequest(false);
    } else {
      listLimitedIds = listIds ? listIds.slice(offset, offset + limit) : [];
    }

    const goods = await Service.getItems(listLimitedIds);
    onSetGoods(goods.result);
    typeGoods !== "goods" && onSetTypeGoods("goods");
    setLoadingGoods(false);
  };

  return (
    <div>
      <button onClick={() => handleReqIsFirst()}>Получить товары</button>
    </div>
  );
};
