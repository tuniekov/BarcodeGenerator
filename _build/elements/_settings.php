<?php

return [
    /*'combo_boolean' => [
        'xtype' => 'combo-boolean',
        'value' => true,
        'area' => 'barcodegenerator_main',
    ],*/
    
    'cart_id' => [
      'xtype' => 'textfield',
      'value' => '1',
      'area' => 'barcodegenerator_main',
    ],
    'naryad_front' => [
        'xtype' => 'textfield',
        'value' => '{
          "showLog": 0,
          "loadModels": "barcodegenerator,tsklad,nomenclature,gtsbalance",
          "selects": {
            "users": [],
            "sech": {
              "type": "select",
              "class": "NomSech",
              "pdoTools": {
                "class": "NomSech",
                "select": "id,label",
                "sortby": {
                  "id": "ASC"
                }
              },
              "content": "{$label}"
            },
            "staff": {
              "type": "autocomplect",
              "class": "gtsBStaff",
              "pdoTools": {
                "class": "gtsBStaff",
                "leftJoin": {
                  "gtsBDepartmentStaffLink": {
                    "class": "gtsBDepartmentStaffLink",
                    "on": "gtsBStaff.id = gtsBDepartmentStaffLink.staff_id"
                  }
                },
                "select": "gtsBStaff.id,gtsBStaff.name",
                "sortby": {
                  "name": "ASC"
                },
                "where": {
                  "gtsBDepartmentStaffLink.department_id": 13
                }
              },
              "where": {
                "gtsBStaff.name:LIKE": "%query%"
              },
              "content": "{$name}"
            },
            "naryad": {
              "type": "autocomplect",
              "class": "SNNaryad",
              "pdoTools": {
                "class": "SNNaryad",
                "leftJoin": {
                  "gtsBStaff": {
                    "class": "gtsBStaff",
                    "on": "gtsBStaff.id = SNNaryad.staff_id"
                  }
                },
                "select": "SNNaryad.id,SNNaryad.date,gtsBStaff.name",
                "sortby": {
                  "id": "DESC"
                }
              },
              "where": {
                "SNNaryad.date:LIKE": "%query%"
              },
              "content": "{$id} {$date | date : \'d.m.Y\'} {$name}"
            },
            "naryad2": {
              "type": "autocomplect",
              "class": "SNNaryad",
              "pdoTools": {
                "class": "SNNaryad",
                "leftJoin": {
                  "gtsBStaff": {
                    "class": "gtsBStaff",
                    "on": "gtsBStaff.id = SNNaryad.staff_id"
                  }
                },
                "select": "SNNaryad.id,SNNaryad.date,SNNaryad.done,gtsBStaff.name",
                "sortby": {
                  "id": "DESC"
                }
              },
              "where": {
                "SNNaryad.date:LIKE": "%query%"
              },
              "content": "{$date | date : \'d.m.Y\'} {$name} {if $done}Выполнен{/if}"
            }
          },
          
          "tabs": {
            "SNDetail": {
              "label": "Детали",
              "table": {
                "name": "SNDetailCart",
                "subtables":{
                  "SNDetail1":{
                    "sub_where": {
                      "tSkladOrderList.sk_order_id": "sk_order_id"
                    },
                    "class": "SNDetail",
                    "actions": {
                      
                      "cart": {
                        "action": "barcodegenerator/cart",
                        "title": "Карта",
                        "multiple": {
                          "title": "Карта"
                        }
                      },
                      "place_modal": {
                        "action": "barcodegenerator/place_modal",
                        "title": "Разместить",
                        "multiple": {
                          "title": "Разместить"
                        }
                      }
                    },
                    "pdoTools": {
                      "class": "SNDetail",
                      "leftJoin": {
                        "tSkladOrderList": {
                          "class": "tSkladOrderList",
                          "on": "tSkladOrderList.id = SNDetail.det_id"
                        },
                        "SNNaryad": {
                          "class": "SNNaryad",
                          "on": "SNNaryad.id = SNDetail.naryad_id"
                        },
                        "gtsBStaff": {
                          "class": "gtsBStaff",
                          "on": "gtsBStaff.id = SNNaryad.staff_id"
                        }
                      },
                      "select": {
                        "SNDetail": "*",
                        "SNNaryad": "CONCAT(SNNaryad.id,\" \",if(SNNaryad.date is null ,\'\',SNNaryad.date),\" \",if(gtsBStaff.name is null ,\'\',gtsBStaff.name)) as naryad_name",
                        "tSkladOrderList": "tSkladOrderList.mark,tSkladOrderList.sech_id,tSkladOrderList.systema,tSkladOrderList.sys_number,tSkladOrderList.name,tSkladOrderList.A,\r\n                tSkladOrderList.B,tSkladOrderList.a_s,tSkladOrderList.b_s,tSkladOrderList.L,tSkladOrderList.number_shina,tSkladOrderList.metall,tSkladOrderList.comment,tSkladOrderList.excel_id,\r\n                tSkladOrderList.count"
                      },
                      "sortby": {
                        "SNDetail.date_done": "ASC",
                        "SNDetail.id": "ASC"
                      }
                    },
                    "checkbox": 1,
                    "autosave": 1,
                    "row": {
                      "cls":"{if $placed}hit{else}warning{/if}",
                      "cols":{
                        "id": {
                          "edit": {
                            "type": "hidden"
                          }
                        },
                        "date_done": {
                          "label": "Дата выпол-нения",
                          "edit": {
                            "type": "date",
                            "readonly": 1
                          },
                          "filter": 1
                        },
                        "room": {
                          "label": "Секция",
                          "edit": {
                            "type": "text",
                            "readonly": 1
                          },
                          "filter": 1
                        },
                        "naryad_id": {
                          "label": "Наряд",
                          "edit": {
                            "type": "select",
                            "select": "naryad2",
                            "field_content": "naryad_name",
                            "readonly": 1
                          },
                          "filter": 1
                        },
                        "count_done": {
                          "label": "Кол-во выпол-неных",
                          "edit": {
                            "type": "text",
                            "readonly": 1
                          },
                          "filter": 1
                        },
                        "placed": {
                          "label": "Разме-щено",
                          "edit": {
                            "type": "checkbox",
                            "readonly": 1
                          },
                          "filter": 1
                        },
                        "excel_id": {
                          "class": "tSkladOrderList",
                          "edit": {
                            "type": "text",
                            "readonly": 1
                          },
                          "filter": 1
                        },
                        "mark": {
                          "class": "tSkladOrderList",
                          "label": "Марки-ровка",
                          "edit": {
                            "type": "text",
                            "readonly": 1
                          },
                          "filter": 1
                        },
                        "sech_id": {
                          "class": "tSkladOrderList",
                          "label": "Сечение",
                          "edit": {
                            "type": "select",
                            "select": "sech",
                            "readonly": 1
                          },
                          "filter": 1
                        },
                        "systema": {
                          "class": "tSkladOrderList",
                          "label": "Система",
                          "content": " ",
                          "filter": 1
                        },
                        "name": {
                          "class": "tSkladOrderList",
                          "label": "Наименование",
                          "edit": {
                            "type": "text",
                            "readonly": 1
                          },
                          "filter": 1
                        },
                        "A": {
                          "class": "tSkladOrderList",
                          "label": "A1/D1 мм",
                          "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                          },
                          "filter": 1
                        },
                        "B": {
                          "class": "tSkladOrderList",
                          "label": "B1/D2 мм",
                          "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                          },
                          "filter": 1
                        },
                        "a_s": {
                          "class": "tSkladOrderList",
                          "label": "A2 мм",
                          "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                          },
                          "filter": 1
                        },
                        "b_s": {
                          "class": "tSkladOrderList",
                          "label": "B2 мм",
                          "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                          },
                          "filter": 1
                        },
                        "L": {
                          "class": "tSkladOrderList",
                          "label": "L , м",
                          "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                          },
                          "filter": 1
                        },
                        "number_shina": {
                          "class": "tSkladOrderList",
                          "label": "Шина",
                          "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                          },
                          "filter": 1
                        },
                        "metall": {
                          "class": "tSkladOrderList",
                          "label": "Металл",
                          "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                          },
                          "filter": 1
                        },
                        "comment": {
                          "class": "tSkladOrderList",
                          "label": "Примечание",
                          "edit": {
                            "type": "view",
                            "readonly": 1,
                            "placeholder": ""
                          },
                          "filter": {
                            "edit": {
                              "type": "text"
                            },
                            "where": "tSkladOrderList.comment:LIKE"
                          }
                        },
                        "count": {
                          "class": "tSkladOrderList",
                          "label": "Зака-зано",
                          "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                          },
                          "filter": 1
                        },
                        "pro_count": {
                          "class": "tSkladOrderList",
                          "label": "Произ-но",
                          "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                          },
                          "filter": 1
                        }
                      }
                    }
                  }
                },
                
                "class": "SNDetail",
                "actions": {
                  "raschet_done": {
                    "action": "barcodegenerator/raschet_done",
                    "title": "Расчет выполнения деталей",
                    "multiple": {
                      "title": "Расчет выполнения деталей"
                    }
                  },
                  "subtable": {
                    "subtable_name": "SNDetail1"
                  }
                },
                "pdoTools": {
                  "class": "SNDetail",
                  "leftJoin": {
                    "tSkladOrderList": {
                      "class": "tSkladOrderList",
                      "on": "tSkladOrderList.id = SNDetail.det_id"
                    },
                    "tSkladOrders": {
                      "class": "tSkladOrders",
                      "on": "tSkladOrders.id = tSkladOrderList.sk_order_id"
                    },
                    "SNNaryad": {
                      "class": "SNNaryad",
                      "on": "SNNaryad.id = SNDetail.naryad_id"
                    },
                    "gtsBStaff": {
                      "class": "gtsBStaff",
                      "on": "gtsBStaff.id = SNNaryad.staff_id"
                    }
                  },
                  "groupby":"tSkladOrderList.sk_order_id",
                  "select": {
                    "SNDetail": "*",
                    "SNNaryad": "CONCAT(if(SNNaryad.date is null ,\'\',SNNaryad.date),\" \",if(gtsBStaff.name is null ,\'\',gtsBStaff.name)) as naryad_name",
                    "tSkladOrders":"tSkladOrders.excel_id,tSkladOrders.comment,sum(SNDetail.count_placed) as sum_count_placed,sum(tSkladOrderList.count) as sum_all_count,tSkladOrderList.sk_order_id"
                  },
                  "sortby": {
                    "SNDetail.date_done": "ASC"
                  }
                },
                "checkbox": 0,
                "autosave": 1,
                "row": {
                  "cls":"{if $sum_all_count == $sum_count_placed}hit{else}warning{/if}",
                  "cols":{
                    "id": {
                      "edit": {
                        "type": "hidden"
                      }
                    },
                    "sk_order_id": {
                      "edit": {
                        "type": "hidden"
                      },
                      "data":1
                    },
                    "date_done": {
                      "label": "Дата выпол-нения",
                      "edit": {
                        "type": "date",
                        "readonly": 1
                      },
                      "filter": 1
                    },
                    "room": {
                      "label": "Секция",
                      "edit": {
                        "type": "text",
                        "readonly": 1
                      },
                      "filter": 1
                    },
                    "naryad_id": {
                      "label": "Наряд",
                      "edit": {
                        "type": "select",
                        "select": "naryad2",
                        "field_content": "naryad_name",
                        "readonly": 1
                      },
                      "filter": 1
                    },
                    "excel_id": {
                      "class":"tSkladOrders",
                      "label": "Заказ №",
                      "edit": {
                        "type": "text",
                        "readonly": 1
                      },
                      "filter": 1
                    },
                    "sum_all_count": {
                      "label": "Кол-во всех деталей",
                      "edit": {
                        "type": "text",
                        "readonly": 1
                      },
                      "filter": 1
                    },
                    "sum_count_placed": {
                      "label": "Кол-во размещенных",
                      "edit": {
                        "type": "text",
                        "readonly": 1
                      },
                      "filter": 1
                    }
                  }
                }
              }
            },
            "SNNaryad": {
              "label": "Наряды",
              "table": {
                "class": "SNNaryad",
                "subtables": {
                  "SNDetail": {
                    "class": "SNDetail",
                    "sub_where": {
                      "SNDetail.naryad_id": "id"
                    },
                    "pdoTools": {
                      "class": "SNDetail",
                      "leftJoin": {
                        "tSkladOrderList": {
                          "class": "tSkladOrderList",
                          "on": "tSkladOrderList.id = SNDetail.det_id"
                        }
                      },
                      "select": {
                        "SNDetail": "*",
                        "tSkladOrderList": "tSkladOrderList.mark,tSkladOrderList.sech_id,tSkladOrderList.systema,tSkladOrderList.sys_number,tSkladOrderList.name,tSkladOrderList.A,\r\n                tSkladOrderList.B,tSkladOrderList.a_s,tSkladOrderList.b_s,tSkladOrderList.L,tSkladOrderList.number_shina,tSkladOrderList.metall,tSkladOrderList.comment,tSkladOrderList.excel_id,\r\n                tSkladOrderList.count"
                      },
                      "sortby": {
                        "tSkladOrderList.mark": "ASC"
                      }
                    },
                    "autosave":1,
                    "row": {
                      "id": {
                        "edit": {"type":"hidden"}
                      },
                      "date_done": {
                        "label": "Дата выполнения",
                        "edit": {
                          "type": "date",
                          "readonly": 1
                        },
                        "filter": 1
                      },
                      "room": {
                        "label": "Секция",
                        "edit": {
                          "type": "text"
                        },
                        "filter": 1
                      },
                      "count_done": {
                        "label": "Кол-во выполненых",
                        "edit": {
                          "type": "text",
                          "readonly": 1
                        },
                        "filter": 1
                      },
                      "mark": {
                        "class": "tSkladOrderList",
                        "label": "Марки-ровка",
                        "edit": {
                          "type": "text",
                          "readonly": 1
                        },
                        "filter": 1
                      },
                      "sech_id": {
                        "class": "tSkladOrderList",
                        "label": "Сечение",
                        "edit": {
                          "type": "select",
                          "select": "sech",
                          "readonly": 1
                        },
                        "filter": 1
                      },
                      "systema": {
                        "class": "tSkladOrderList",
                        "label": "Система",
                        "content": " ",
                        "filter": 1
                      },
                      "name": {
                        "class": "tSkladOrderList",
                        "label": "Наименование",
                        "edit": {
                          "type": "text",
                          "readonly": 1
                        },
                        "filter": 1
                      },
                      "A": {
                        "class": "tSkladOrderList",
                        "label": "A1/D1 мм",
                        "edit": {
                          "type": "text",
                          "readonly": 1,
                          "placeholder": ""
                        },
                        "filter": 1
                      },
                      "B": {
                        "class": "tSkladOrderList",
                        "label": "B1/D2 мм",
                        "edit": {
                          "type": "text",
                          "readonly": 1,
                          "placeholder": ""
                        },
                        "filter": 1
                      },
                      "a_s": {
                        "class": "tSkladOrderList",
                        "label": "A2 мм",
                        "edit": {
                          "type": "text",
                          "readonly": 1,
                          "placeholder": ""
                        },
                        "filter": 1
                      },
                      "b_s": {
                        "class": "tSkladOrderList",
                        "label": "B2 мм",
                        "edit": {
                          "type": "text",
                          "readonly": 1,
                          "placeholder": ""
                        },
                        "filter": 1
                      },
                      "L": {
                        "class": "tSkladOrderList",
                        "label": "L , м",
                        "edit": {
                          "type": "text",
                          "readonly": 1,
                          "placeholder": ""
                        },
                        "filter": 1
                      },
                      "number_shina": {
                        "class": "tSkladOrderList",
                        "label": "Шина",
                        "edit": {
                          "type": "text",
                          "readonly": 1,
                          "placeholder": ""
                        },
                        "filter": 1
                      },
                      "metall": {
                        "class": "tSkladOrderList",
                        "label": "Металл",
                        "edit": {
                          "type": "text",
                          "readonly": 1,
                          "placeholder": ""
                        },
                        "filter": 1
                      },
                      "comment": {
                        "class": "tSkladOrderList",
                        "label": "Примечание",
                        "edit": {
                          "type": "view",
                          "readonly": 1,
                          "placeholder": ""
                        },
                        "filter": {
                          "edit": {
                            "type": "text"
                          },
                          "where": "tSkladOrderList.comment:LIKE"
                        }
                      },
                      "count": {
                        "class": "tSkladOrderList",
                        "label": "Зака-зано",
                        "edit": {
                          "type": "text",
                          "readonly": 1,
                          "placeholder": ""
                        },
                        "filter": 1
                      },
                      "pro_count": {
                        "class": "tSkladOrderList",
                        "label": "Произ-но",
                        "edit": {
                          "type": "text",
                          "readonly": 1,
                          "placeholder": ""
                        },
                        "filter": 1
                      }
                    }
                  }
                },
                "actions": {
                  "create": [],
                  "update": [],
                  "print": {
                    "action": "barcodegenerator/print",
                    "title": "Печать",
                    "multiple": {
                      "title": "Печать"
                    }
                  },
                  "subtable": {
                    "subtable_name": "SNDetail"
                  }
                },
                "pdoTools": {
                  "class": "SNNaryad",
                  "leftJoin": {
                    "gtsBStaff": {
                      "class": "gtsBStaff",
                      "on": "gtsBStaff.id = SNNaryad.staff_id"
                    }
                  },
                  "subpdo":{
                    "excel_ids": {
                      "class": "SNDetail",
                      "leftJoin": {
                        "tSkladOrderList": {
                          "class": "tSkladOrderList",
                          "on": "tSkladOrderList.id = SNDetail.det_id"
                        }
                      },
                      "where": {
                        "1":"SNDetail.naryad_id=SNNaryad.id"
                      },
                      "groupby":"SNDetail.naryad_id",
                      "select": {
                        "tSkladOrderList": "group_concat(DISTINCT tSkladOrderList.excel_id separator \',\') as excel_ids1"
                      },
                      "sortby": {
                        "id": "DESC"
                      }
                    }
                  },
                  "select": {
                    "SNNaryad": "*",
                    "gtsBStaff": "gtsBStaff.name as staff_name,({$subpdo.excel_ids}) as excel_ids"
                  },
                  "sortby": {
                    "id": "DESC"
                  }
                },
                "checkbox": 1,
                "autosave": 1,
                "row": {
                  "id": {
                    "filter": 1
                  },
                  "date": {
                    "label": "Дата",
                    "edit": {
                      "type": "date"
                    },
                    "default": "+1 days",
                    "filter": 1
                  },
                  "staff_id": {
                    "label": "Сотрудник",
                    "edit": {
                      "type": "select",
                      "select": "staff",
                      "field_content": "staff_name"
                    },
                    "filter": 1
                  },
                  "excel_ids": {
                    "label": "№ заказов",
                    "edit": {
                      "type": "text",
                      "readonly": 1
                    },
                    "row_only": 1,
                    "filter": 1
                  },
                  "done": {
                    "label": "Выполнено",
                    "edit": {
                      "type": "checkbox"
                    },
                    "filter": 1
                  }
                }
              }
            }
          }
        }',
        'area' => 'barcodegenerator_main',
    ],
    'naryad_front_cart' => [
        'xtype' => 'textfield',
        'value' => '{
            "showLog": 0,
            "loadModels": "barcodegenerator,tsklad,nomenclature",
            "selects": {
                "users": [],
                "sech": {
                    "type": "select",
                    "class": "NomSech",
                    "pdoTools": {
                        "class": "NomSech",
                        "select": "id,label",
                        "sortby": {
                            "id": "ASC"
                        }
                    },
                    "content": "{$label}"
                }
            },
            "table": {
                "name": "SNDetailCart",
                "class": "SNDetail",
                "actions": {
                    
                },
                "pdoTools": {
                    "class": "SNDetail",
                    "leftJoin": {
                        "tSkladOrderList": {
                            "class": "tSkladOrderList",
                            "on": "tSkladOrderList.id = SNDetail.det_id"
                        }
                    },
                    "select": {
                        "SNDetail": "*",
                        "tSkladOrderList": "tSkladOrderList.mark,tSkladOrderList.sech_id,tSkladOrderList.systema,tSkladOrderList.sys_number,tSkladOrderList.name,tSkladOrderList.A,\r\n                tSkladOrderList.B,tSkladOrderList.a_s,tSkladOrderList.b_s,tSkladOrderList.L,tSkladOrderList.number_shina,tSkladOrderList.metall,tSkladOrderList.comment,tSkladOrderList.excel_id,\r\n                tSkladOrderList.count"
                    },
                    "sortby": {
                        "date_done": "ASC"
                    }
                },
                "checkbox": 0,
                "autosave": 1,
                "row": {
                    "id": {
                        "edit": {
                            "type": "hidden"
                        }
                    },
                    "date_done": {
                        "label": "\u0414\u0430\u0442\u0430 \u0432\u044b\u043f\u043e\u043b\u043d\u0435\u043d\u0438\u044f",
                        "edit": {
                            "type": "date",
                            "readonly": 1
                        },
                        "filter": 1
                    },
                    "room": {
                        "label": "\u0421\u0435\u043a\u0446\u0438\u044f",
                        "edit": {
                            "type": "text",
                            "readonly": 1
                        },
                        "filter": 1
                    },
                    "count_done": {
                        "label": "\u041a\u043e\u043b-\u0432\u043e \u0432\u044b\u043f\u043e\u043b\u043d\u0435\u043d\u044b\u0445",
                        "edit": {
                            "type": "text",
                            "readonly": 1
                        },
                        "filter": 1
                    },
                    "placed": {
                        "label": "\u0420\u0430\u0437\u043c\u0435\u0449\u0435\u043d\u043e",
                        "edit": {
                            "type": "checkbox",
                            "readonly": 1
                        },
                        "filter": 1
                    },
                    "excel_id": {
                        "class": "tSkladOrderList",
                        "edit": {
                            "type": "text",
                            "readonly": 1
                        },
                        "filter": 1
                    },
                    "mark": {
                        "class": "tSkladOrderList",
                        "label": "\u041c\u0430\u0440\u043a\u0438-\u0440\u043e\u0432\u043a\u0430",
                        "edit": {
                            "type": "text",
                            "readonly": 1
                        },
                        "filter": 1
                    },
                    "sech_id": {
                        "class": "tSkladOrderList",
                        "label": "\u0421\u0435\u0447\u0435\u043d\u0438\u0435",
                        "edit": {
                            "type": "select",
                            "select": "sech",
                            "readonly": 1
                        },
                        "filter": 1
                    },
                    "systema": {
                        "class": "tSkladOrderList",
                        "label": "\u0421\u0438\u0441\u0442\u0435\u043c\u0430",
                        "content": " ",
                        "filter": 1
                    },
                    "name": {
                        "class": "tSkladOrderList",
                        "label": "\u041d\u0430\u0438\u043c\u0435\u043d\u043e\u0432\u0430\u043d\u0438\u0435",
                        "edit": {
                            "type": "view",
                            "readonly": 1
                        },
                        "filter": 1
                    },
                    "A": {
                        "class": "tSkladOrderList",
                        "label": "A1\/D1 \u043c\u043c",
                        "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                        },
                        "filter": 1
                    },
                    "B": {
                        "class": "tSkladOrderList",
                        "label": "B1\/D2 \u043c\u043c",
                        "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                        },
                        "filter": 1
                    },
                    "a_s": {
                        "class": "tSkladOrderList",
                        "label": "A2 \u043c\u043c",
                        "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                        },
                        "filter": 1
                    },
                    "b_s": {
                        "class": "tSkladOrderList",
                        "label": "B2 \u043c\u043c",
                        "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                        },
                        "filter": 1
                    },
                    "L": {
                        "class": "tSkladOrderList",
                        "label": "L , \u043c",
                        "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                        },
                        "filter": 1
                    },
                    "number_shina": {
                        "class": "tSkladOrderList",
                        "label": "\u0428\u0438\u043d\u0430",
                        "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                        },
                        "filter": 1
                    },
                    "metall": {
                        "class": "tSkladOrderList",
                        "label": "\u041c\u0435\u0442\u0430\u043b\u043b",
                        "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                        },
                        "filter": 1
                    },
                    "comment": {
                        "class": "tSkladOrderList",
                        "label": "\u041f\u0440\u0438\u043c\u0435\u0447\u0430\u043d\u0438\u0435",
                        "edit": {
                            "type": "view",
                            "readonly": 1,
                            "placeholder": ""
                        },
                        "filter": {
                            "edit": {
                                "type": "text"
                            },
                            "where": "tSkladOrderList.comment:LIKE"
                        }
                    },
                    "count": {
                        "class": "tSkladOrderList",
                        "label": "\u0417\u0430\u043a\u0430-\u0437\u0430\u043d\u043e",
                        "edit": {
                            "type": "text",
                            "readonly": 1,
                            "placeholder": ""
                        },
                        "filter": 1
                    }
                }
            }
        }',
        'area' => 'barcodegenerator_main',
    ],
];