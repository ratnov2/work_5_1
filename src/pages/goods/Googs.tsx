import { useEffect, useState } from "react";
import { Service } from "../../api/service";
import { TGoods } from "../../type";
import style from "./goods.module.css";
import { WithBrandSelect } from "./selects/WithSelect/WithBrandSelect";
import { WithProductSelect } from "./selects/WithSelect/WithProductSelect";
import { WithPriceSelect } from "./selects/WithSelect/WithPriceSelect";
import Paginator from "./paginator/Paginator";
export const Goods = () => {
  const [currentPagination, setCurrentPagination] = useState<
    "filter" | "getAllGoods"
  >("getAllGoods");
  //
  const [goods, setGoods] = useState<TGoods[]>([]);
  const [goodsInfo, setGoodsInfo] = useState<number>();
  const [isEndPagination, setIsEndpagination] = useState(true);

  //pagination
  const [currentOffset, setCurrentOffset] = useState(0);
  const [currentLimit, setCurrentLimit] = useState(10);
  /////
  const [loadingGoods, setLoadingGoods] = useState(false);
  //
  const [pricesSelect, setPricesSelect] = useState<string>("Ничего не выбрано");
  const [brandsSelect, setBrandsSelect] = useState<string>("Ничего не выбрано");
  const [productsSelect, setProductsSelect] =
    useState<string>("Ничего не выбрано");
  ////

  const getFilteredGoods = (offset = currentOffset, limit = currentLimit) => {
    const filteredItems: { [key: string]: number | string } = {};
    if (pricesSelect !== "Ничего не выбрано")
      filteredItems.price = +pricesSelect;
    if (brandsSelect !== "Ничего не выбрано")
      filteredItems.brand = brandsSelect;
    if (productsSelect !== "Ничего не выбрано")
      filteredItems.product = productsSelect;
    Service.getGoodsByActionFilter(filteredItems).then(
      ({ items, itemLength, isEndPagination }) => {
        setGoods(items);
        setGoodsInfo(itemLength);
        setLoadingGoods(false);
      }
    );
  };

  const getGoods = (offset = currentOffset, limit = currentLimit) => {
    if (currentPagination === "filter") offset = 0;
    setLoadingGoods(true);
    Service.getGoods(offset, limit).then(({ items }) => {
      setGoods(items);
      setIsEndpagination(items.isEndPagination);
      setLoadingGoods(false);
    });
  };
  const isDisabledFilteredButton = () =>
    pricesSelect === "Ничего не выбрано" &&
    brandsSelect === pricesSelect &&
    productsSelect === brandsSelect;

  const handleClickLeft = () => {
    let offsetVar = currentOffset - currentLimit;
    if (currentPagination === "getAllGoods" || currentPagination === "filter") {
      if (currentOffset - currentLimit < 0) {
        offsetVar = 0;
        setCurrentOffset(0);
      } else {
        setCurrentOffset(offsetVar);
      }
      currentPagination === "getAllGoods" && getGoods(offsetVar);
    }
    // else if(currentPagination === 'filter'){

    // }
  };
  const handleClickRight = () => {
    let offsetVar = currentOffset;
    if (!isEndPagination) {
      offsetVar = currentOffset + currentLimit;
      setCurrentOffset(offsetVar);
    }
    currentPagination === "getAllGoods" && getGoods(offsetVar);
  };
  return (
    <div>
      <h1>Просто получить список товаров без фильтра</h1>
      <button disabled={loadingGoods} onClick={() => getGoods()}>
        Get Goods
      </button>
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
        onClick={() => getFilteredGoods()}
      >
        Получить отфильтрованный список
      </button>
      <h1>
        Ваши товары{" "}
        {`(offset = ${currentOffset}) isLoading = ${loadingGoods} // length = ${goodsInfo}`}
      </h1>
      {goodsInfo && (
        <Paginator
          totalItems={goodsInfo}
          itemsPerPage={currentLimit}
          onPageChange={() => ""}
        />
      )}
      <div>
        <button
          disabled={goods.length === 0 || currentOffset <= 0 || loadingGoods}
          onClick={() => {
            handleClickLeft();
          }}
        >
          Click Left
        </button>
        <button
          disabled={loadingGoods || isEndPagination}
          onClick={() => handleClickRight()}
        >
          Click Right
        </button>
      </div>
      {goods.length !== 0 ? (
        goods.map((item) => (
          <article className={style.goods}>
            <h2>{item.product}</h2>
            <h2>{item.brand || "No Brand"}</h2>
            <h2>{item.price}</h2>
            <h2>{item.id}</h2>
          </article>
        ))
      ) : (
        <div>Упс, по вашему запросу ничего не найдено</div>
      )}
    </div>
  );
};
